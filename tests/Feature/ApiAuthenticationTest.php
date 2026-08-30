<?php

declare(strict_types=1);

use App\Enums\LibraryEntryStatus;
use App\Models\LibraryEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * The API Platform routes are protected by the default middleware in config/api-platform.php
 * rather than by anything in routes/, so nothing in the route files hints that removing it opens
 * every resource. These tests are the guard against that.
 */
test('guests cannot reach the api', function (string $method, string $uri) {
    $this->json($method, $uri, [], ['Accept' => 'application/vnd.api+json'])
        ->assertUnauthorized();
})->with([
    'library entry collection' => ['GET', '/api/library_entries'],
    'library entry item' => ['GET', '/api/library_entries/1'],
    'library entry creation' => ['POST', '/api/library_entries'],
    'library entry update' => ['PATCH', '/api/library_entries/1'],
    'library entry deletion' => ['DELETE', '/api/library_entries/1'],
    'user collection' => ['GET', '/api/users'],
    'user item' => ['GET', '/api/users/00000000-0000-0000-0000-000000000000'],
    'user update' => ['PATCH', '/api/users/00000000-0000-0000-0000-000000000000'],
]);

/**
 * The collection doubles as the current-user endpoint, so a client that does not know its own id
 * can still fetch itself. This is the test that matters if OwnedResourcesExtension ever stops
 * being applied: without it the same request would return every user in the database.
 */
test('the user collection holds the caller and nobody else', function () {
    $user = User::factory()->create();
    User::factory()->count(3)->create();

    $response = actingAsNative($user)
        ->getJson('/api/users', ['Accept' => 'application/vnd.api+json'])
        ->assertOk();

    expect($response->json('data'))->toHaveCount(1)
        ->and($response->json('data.0.id'))->toBe($user->id);
});

test('an unauthenticated request cannot reach the user collection', function () {
    User::factory()->create();

    $this->getJson('/api/users', ['Accept' => 'application/vnd.api+json'])
        ->assertUnauthorized();
});

test('a user can read their own resource but not someone elses', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    actingAsNative($user)
        ->getJson("/api/users/{$user->id}", ['Accept' => 'application/vnd.api+json'])
        ->assertOk()
        ->assertJsonPath('data.id', $user->id);

    // 404, not 403: OwnedResourcesExtension scopes the query, so someone else's resource does not
    // exist as far as this caller is concerned. Same shape as library entries.
    actingAsNative($user)
        ->getJson("/api/users/{$other->id}", ['Accept' => 'application/vnd.api+json'])
        ->assertNotFound();
});

test('the api never exposes a users email', function () {
    $user = User::factory()->create(['email' => 'private@example.test']);
    LibraryEntry::create([
        'user_id' => $user->id,
        'game_id' => 1,
        'status' => LibraryEntryStatus::Playing,
        'owned' => true,
    ]);

    $response = actingAsNative($user)
        ->getJson("/api/users/{$user->id}", ['Accept' => 'application/vnd.api+json'])
        ->assertOk();

    expect($response->getContent())->not->toContain('private@example.test');
});
