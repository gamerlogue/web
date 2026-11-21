<?php

declare(strict_types=1);

use App\Models\DeviceToken;
use App\Models\User;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Exception\Messaging\ServerUnavailable;
use Kreait\Firebase\Messaging\MessageTarget;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Kreait\Firebase\Messaging\SendReport;
use NotificationChannels\Fcm\FcmMessage;

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

test('a notification is pushed to every device of its recipient', function () {
    $owner = User::factory()->create();
    $fan = User::factory()->create(['nickname' => 'fan']);
    DeviceToken::create(['user_id' => $owner->id, 'token' => 'phone', 'platform' => 'android']);
    DeviceToken::create(['user_id' => $owner->id, 'token' => 'tablet', 'platform' => 'android']);
    $this->mock(Messaging::class)->shouldReceive('sendMulticast')->once()
        ->with(Mockery::capture($message), ['phone', 'tablet'])
        ->andReturn(MulticastSendReport::withItems([]));

    actingAsNative($fan)->postJson('/api/follows', ['data' => ['type' => 'Follow', 'attributes' => ['followable_id' => $owner->id]]], jsonApiHeaders())->assertCreated();

    expect($message)->toBeInstanceOf(FcmMessage::class)
        ->and($message->toArray())->toBe([
            'data' => ['notification_id' => $owner->notifications()->sole()->id, 'type' => 'new_follower'],
            'notification' => ['title' => 'New follower', 'body' => 'fan started following you'],
            'android' => ['notification' => ['channel_id' => 'social']],
        ]);
});

test('nothing is pushed to a recipient without devices', function () {
    $owner = User::factory()->create();
    $this->mock(Messaging::class)->shouldNotReceive('sendMulticast');

    actingAsNative(User::factory()->create())->postJson('/api/follows', ['data' => ['type' => 'Follow', 'attributes' => ['followable_id' => $owner->id]]], jsonApiHeaders())->assertCreated();

    expect($owner->notifications()->count())->toBe(1);
});

test('a token FCM no longer knows is forgotten, one failing for other reasons is kept', function () {
    $owner = User::factory()->create();
    DeviceToken::create(['user_id' => $owner->id, 'token' => 'gone', 'platform' => 'android']);
    DeviceToken::create(['user_id' => $owner->id, 'token' => 'busy', 'platform' => 'android']);
    $this->mock(Messaging::class)->shouldReceive('sendMulticast')->once()->andReturn(MulticastSendReport::withItems([
        SendReport::failure(MessageTarget::with(MessageTarget::TOKEN, 'gone'), NotFound::becauseTokenNotFound('gone')),
        SendReport::failure(MessageTarget::with(MessageTarget::TOKEN, 'busy'), new ServerUnavailable('Unavailable')),
    ]));

    actingAsNative(User::factory()->create())->postJson('/api/follows', ['data' => ['type' => 'Follow', 'attributes' => ['followable_id' => $owner->id]]], jsonApiHeaders())->assertCreated();

    expect(DeviceToken::pluck('token')->all())->toBe(['busy']);
});
