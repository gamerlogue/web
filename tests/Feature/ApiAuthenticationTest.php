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

test('an authenticated user cannot list every user', function () {
    $user = User::factory()->create();

    // UserFormRequest::authorize() compares the route id with the current user, and a collection
    // has none: the endpoint exists but stays closed.
    $this->actingAs($user, 'sanctum')
        ->getJson('/api/users', ['Accept' => 'application/vnd.api+json'])
        ->assertForbidden();
});

test('a user can read their own resource but not someone elses', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->getJson("/api/users/{$user->id}", ['Accept' => 'application/vnd.api+json'])
        ->assertOk()
        ->assertJsonPath('data.id', $user->id);

    $this->actingAs($user, 'sanctum')
        ->getJson("/api/users/{$other->id}", ['Accept' => 'application/vnd.api+json'])
        ->assertForbidden();
});

test('the api never exposes a users email', function () {
    $user = User::factory()->create(['email' => 'private@example.test']);
    LibraryEntry::create([
        'user_id' => $user->id,
        'game_id' => 1,
        'status' => LibraryEntryStatus::Playing,
        'owned' => true,
    ]);

    $response = $this->actingAs($user, 'sanctum')
        ->getJson("/api/users/{$user->id}", ['Accept' => 'application/vnd.api+json'])
        ->assertOk();

    expect($response->getContent())->not->toContain('private@example.test');
});
