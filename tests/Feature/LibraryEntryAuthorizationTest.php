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

test('a user cannot create a library entry for another user', function () {
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
        ->assertForbidden();
});

test('a user can create their own library entry', function () {
    $user = User::factory()->create(['nickname' => 'owner']);

    $this->actingAs($user, 'sanctum')
        ->json('POST', '/api/library_entries', [
            'data' => [
                'type' => 'LibraryEntry',
                'attributes' => [
                    'user_id' => $user->id,
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
    expect($entry)->not->toBeNull();
    expect($entry->editions_ids)->toBe([123, 456]);
    expect($entry->platforms_ids)->toBe([48, 49]);
});

test('a user cannot patch another user\'s library entry', function () {
    $user = User::factory()->create(['nickname' => 'owner']);
    $other = User::factory()->create(['nickname' => 'other']);
    $entry = LibraryEntry::create([
        'user_id' => $other->id,
        'game_id' => 1,
        'status' => LibraryEntryStatus::Playing,
        'owned' => true,
    ]);

    $this->actingAs($user, 'sanctum')
        ->json('PATCH', "/api/library_entries/{$entry->id}", [
            'data' => [
                'type' => 'LibraryEntry',
                'id' => (string) $entry->id,
                'attributes' => ['status' => LibraryEntryStatus::Completed->value],
            ],
        ], jsonApiHeaders())
        ->assertForbidden();

    expect($entry->fresh()->status)->toBe(LibraryEntryStatus::Playing);
});
