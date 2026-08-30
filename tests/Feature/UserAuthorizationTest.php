<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user cannot patch another user', function () {
    $user = User::factory()->create(['nickname' => 'owner']);
    $other = User::factory()->create(['nickname' => 'other']);

    actingAsNative($user)
        ->json('PATCH', "/api/users/{$other->id}", [
            'data' => [
                'type' => 'User',
                'id' => $other->id,
                'attributes' => ['nickname' => 'hacked'],
            ],
        ], ['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])
        // 404 rather than 403: OwnedResourcesExtension scopes the query before authorization runs,
        // so another user's resource is simply not there for this caller.
        ->assertNotFound();

    expect($other->fresh()->nickname)->toBe('other');
});

test('a user can patch themselves', function () {
    $user = User::factory()->create(['nickname' => 'owner']);

    actingAsNative($user)
        ->json('PATCH', "/api/users/{$user->id}", [
            'data' => [
                'type' => 'User',
                'id' => $user->id,
                'attributes' => ['nickname' => 'renamed'],
            ],
        ], ['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])
        ->assertOk();

    expect($user->fresh()->nickname)->toBe('renamed');
});

test('a native token without the profile ability cannot patch the user', function () {
    $user = User::factory()->create(['nickname' => 'owner']);

    actingAsNative($user, ['library'])
        ->json('PATCH', "/api/users/{$user->id}", [
            'data' => [
                'type' => 'User',
                'id' => $user->id,
                'attributes' => ['nickname' => 'renamed'],
            ],
        ], ['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])
        ->assertForbidden();

    expect($user->fresh()->nickname)->toBe('owner');
});

/**
 * A token holding the wildcard ability is not narrowed by the checks above. This is what
 * Sanctum's TransientToken grants, so it also covers any caller authenticated without a personal
 * access token.
 *
 * It deliberately says nothing about the browser: an actual OIDC session does NOT reach these
 * routes today, because the API middleware stack has neither StartSession nor
 * EnsureFrontendRequestsAreStateful. Measured, not assumed — a real session cookie gets a 401.
 */
test('a token with the wildcard ability is not narrowed', function () {
    $user = User::factory()->create(['nickname' => 'owner']);

    actingAsNative($user, ['*'])
        ->json('PATCH', "/api/users/{$user->id}", [
            'data' => [
                'type' => 'User',
                'id' => $user->id,
                'attributes' => ['nickname' => 'from-a-wildcard-token'],
            ],
        ], ['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])
        ->assertOk();

    expect($user->fresh()->nickname)->toBe('from-a-wildcard-token');
});
