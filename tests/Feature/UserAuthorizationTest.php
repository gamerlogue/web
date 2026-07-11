<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user cannot patch another user', function () {
    $user = User::factory()->create(['nickname' => 'owner']);
    $other = User::factory()->create(['nickname' => 'other']);

    $this->actingAs($user, 'sanctum')
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

    $this->actingAs($user, 'sanctum')
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
