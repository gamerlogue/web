<?php

declare(strict_types=1);

use App\Enums\LibraryEntryStatus;
use App\Models\LibraryEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function jsonApiHeaders(): array
{
    return ['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'];
}

test('a supplied owner is replaced with the authenticated user', function () {
    $user = User::factory()->create(['nickname' => 'owner']);
    $other = User::factory()->create(['nickname' => 'other']);

    $this->actingAs($user, 'sanctum')
        ->json('POST', '/api/library_entries', [
            'data' => [
                'type' => 'LibraryEntry',
                'attributes' => [
                    'user_id' => $other->id,
                    'game_id' => 1,
                    'status' => LibraryEntryStatus::Playing->value,
                    'owned' => true,
                ],
            ],
        ], jsonApiHeaders())
        ->assertCreated();

    expect(LibraryEntry::query()->sole()->user_id)->toBe($user->id);
});

test('a user can create their own library entry', function () {
    $user = User::factory()->create(['nickname' => 'owner']);

    $this->actingAs($user, 'sanctum')
        ->json('POST', '/api/library_entries', [
            'data' => [
                'type' => 'LibraryEntry',
                'attributes' => [
                    'game_id' => 1,
                    'status' => LibraryEntryStatus::Playing->value,
                    'owned' => true,
                    'editions_ids' => [123, 456],
                    'platforms_ids' => [48, 49],
                ],
            ],
        ], jsonApiHeaders())
        ->assertCreated();

    $entry = LibraryEntry::where('user_id', $user->id)->where('game_id', 1)->first();

    expect($entry)->not->toBeNull()
        ->and($entry->editions_ids)->toBe([123, 456])
        ->and($entry->platforms_ids)->toBe([48, 49]);

    // The array attributes must survive the round trip through the serializer, too.
    $this->actingAs($user, 'sanctum')
        ->getJson("/api/library_entries/{$entry->id}", jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.attributes.editions_ids', [123, 456])
        ->assertJsonPath('data.attributes.platforms_ids', [48, 49]);
});

test('a user can patch their own entry without resubmitting its owner', function () {
    $user = User::factory()->create();
    $entry = LibraryEntry::create([
        'user_id' => $user->id,
        'game_id' => 1,
        'status' => LibraryEntryStatus::Playing,
        'owned' => true,
    ]);

    $this->actingAs($user, 'sanctum')
        ->json('PATCH', "/api/library_entries/{$entry->id}", [
            'data' => [
                'type' => 'LibraryEntry',
                'id' => (string) $entry->id,
                'attributes' => [
                    'status' => LibraryEntryStatus::Completed->value,
                    'platforms_ids' => [6],
                ],
            ],
        ], jsonApiHeaders())
        ->assertOk();

    expect($entry->fresh()->status)->toBe(LibraryEntryStatus::Completed)
        ->and($entry->fresh()->platforms_ids)->toBe([6]);
});

test('a user cannot patch or delete another users library entry', function (string $method) {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $entry = LibraryEntry::create([
        'user_id' => $other->id,
        'game_id' => 1,
        'status' => LibraryEntryStatus::Playing,
        'owned' => true,
    ]);

    $this->actingAs($user, 'sanctum')
        ->json($method, "/api/library_entries/{$entry->id}", [
            'data' => [
                'type' => 'LibraryEntry',
                'id' => (string) $entry->id,
                'attributes' => ['status' => LibraryEntryStatus::Completed->value],
            ],
        ], jsonApiHeaders())
        ->assertNotFound();

    expect($entry->fresh())->not->toBeNull();
})->with(['PATCH', 'DELETE']);

test('users only see their own library entries', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    LibraryEntry::create([
        'user_id' => $user->id,
        'game_id' => 1,
        'status' => LibraryEntryStatus::Playing,
        'owned' => true,
    ]);
    $otherEntry = LibraryEntry::create([
        'user_id' => $other->id,
        'game_id' => 2,
        'status' => LibraryEntryStatus::Playing,
        'owned' => true,
    ]);

    $this->actingAs($user, 'sanctum')
        ->getJson('/api/library_entries', jsonApiHeaders())
        ->assertOk()
        ->assertJsonCount(1, 'data');

    $this->actingAs($user, 'sanctum')
        ->getJson("/api/library_entries/{$otherEntry->id}", jsonApiHeaders())
        ->assertNotFound();
});

test('a user can delete their own library entry', function () {
    $user = User::factory()->create();
    $entry = LibraryEntry::create([
        'user_id' => $user->id,
        'game_id' => 1,
        'status' => LibraryEntryStatus::Playing,
        'owned' => true,
    ]);

    $this->actingAs($user, 'sanctum')
        ->json('DELETE', "/api/library_entries/{$entry->id}", headers: jsonApiHeaders())
        ->assertNoContent();

    expect($entry->fresh())->toBeNull();
});

test('a user cannot transfer an entry to another user', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $entry = LibraryEntry::create([
        'user_id' => $user->id,
        'game_id' => 1,
        'status' => LibraryEntryStatus::Playing,
        'owned' => true,
    ]);

    $this->actingAs($user, 'sanctum')
        ->json('PATCH', "/api/library_entries/{$entry->id}", [
            'data' => [
                'type' => 'LibraryEntry',
                'id' => (string) $entry->id,
                'attributes' => ['user_id' => $other->id],
            ],
        ], jsonApiHeaders())
        ->assertUnprocessable()
        // JSON:API reports errors under "errors", not Laravel's "errors.<field>" shape.
        ->assertJsonPath('errors.0.code', fn (string $code) => str_ends_with($code, '/data.attributes.user_id'));

    expect($entry->fresh()->user_id)->toBe($user->id);
});

test('ill-typed attributes are rejected during deserialization', function (array $attributes) {
    $user = User::factory()->create();

    // Deserialization happens before validation, so these never reach the FormRequest rules.
    $this->actingAs($user, 'sanctum')
        ->json('POST', '/api/library_entries', [
            'data' => [
                'type' => 'LibraryEntry',
                'attributes' => ['game_id' => 1, 'status' => LibraryEntryStatus::Playing, ...$attributes],
            ],
        ], jsonApiHeaders())
        ->assertUnprocessable();
})->with([
    'unknown status' => [['status' => 'INVALID']],
    'scalar instead of array' => [['rating_details' => 'invalid']],
]);

test('validates library entry boundaries', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->json('POST', '/api/library_entries', [
            'data' => [
                'type' => 'LibraryEntry',
                'attributes' => [
                    'game_id' => 1,
                    'status' => LibraryEntryStatus::Playing,
                    'played_time' => -1,
                    'rating' => 101,
                    'start_date' => '2026-08-10',
                    'end_date' => '2026-08-09',
                ],
            ],
        ], jsonApiHeaders())
        ->assertUnprocessable();

    // JSON:API puts one entry per failed field under "errors", keyed by a "<hash>/<field>" code.
    $failedFields = collect($response->json('errors'))
        ->map(fn (array $error): string => str($error['code'])->afterLast('/')->toString())
        ->all();

    expect($failedFields)->toContain(
        'data.attributes.played_time',
        'data.attributes.rating',
        'data.attributes.end_date',
    );
});
