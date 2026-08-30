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
        ->assertForbidden();

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
 * The browser reaches the same API through the OIDC session, which Sanctum authenticates with a
 * TransientToken. That token grants every ability, so the checks above must not lock the web out.
 */
test('a session request is not blocked by the token abilities', function () {
    $user = User::factory()->create(['nickname' => 'owner']);

    $this->actingAs($user)
        ->json('PATCH', "/api/users/{$user->id}", [
            'data' => [
                'type' => 'User',
                'id' => $user->id,
                'attributes' => ['nickname' => 'from-the-browser'],
            ],
        ], ['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])
        ->assertOk();

    expect($user->fresh()->nickname)->toBe('from-the-browser');
});
