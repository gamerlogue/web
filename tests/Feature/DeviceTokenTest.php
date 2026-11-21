<?php

declare(strict_types=1);

use App\Models\DeviceToken;
use App\Models\User;

test('a device token is registered, refreshed and moved to whoever registers it last', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    actingAsNative($user)->postJson('/api/device-tokens', ['token' => 'abc', 'platform' => 'android'])->assertNoContent();
    $registeredAt = DeviceToken::sole()->updated_at;

    $this->travel(1)->minutes();
    actingAsNative($user)->postJson('/api/device-tokens', ['token' => 'abc', 'platform' => 'android'])->assertNoContent();
    expect(DeviceToken::sole()->updated_at->isAfter($registeredAt))->toBeTrue();

    actingAsNative($other)->postJson('/api/device-tokens', ['token' => 'abc', 'platform' => 'android'])->assertNoContent();
    expect(DeviceToken::sole()->user_id)->toBe($other->id);
});

test('registering a device token needs the profile ability', function () {
    $this->postJson('/api/device-tokens', ['token' => 'abc', 'platform' => 'android'])->assertUnauthorized();
    actingAsNative(User::factory()->create(), ['library'])->postJson('/api/device-tokens', ['token' => 'abc', 'platform' => 'android'])->assertForbidden();

    expect(DeviceToken::count())->toBe(0);
});

test('a malformed device token is rejected', function (array $body, string $field) {
    actingAsNative(User::factory()->create())->postJson('/api/device-tokens', $body)
        ->assertUnprocessable()
        ->assertJsonValidationErrors($field);
})->with([
    'no token' => [['platform' => 'android'], 'token'],
    'token too long' => [['token' => str_repeat('a', 4097), 'platform' => 'android'], 'token'],
    'no platform' => [['token' => 'abc'], 'platform'],
    'unknown platform' => [['token' => 'abc', 'platform' => 'ios'], 'platform'],
]);
