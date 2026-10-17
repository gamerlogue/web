<?php

declare(strict_types=1);

use App\Enums\LibraryEntryStatus;
use App\Enums\Visibility;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\User;
use App\Models\UserBlock;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;

function followRequest(User $follower, string $followedId): TestResponse
{
    return actingAsNative($follower)->postJson('/api/follows', [
        'data' => ['type' => 'Follow', 'attributes' => ['followable_id' => $followedId]],
    ], jsonApiHeaders());
}

function blockRequest(User $blocker, string $blockedId): TestResponse
{
    return actingAsNative($blocker)->postJson('/api/blocks', [
        'data' => ['type' => 'Block', 'attributes' => ['blocked_id' => $blockedId]],
    ], jsonApiHeaders());
}

/**
 * @return list<string>
 */
function userIds(User $viewer, string $uri): array
{
    return collect(actingAsNative($viewer)->getJson($uri, jsonApiHeaders())->assertOk()->json('data'))->pluck('id')->all();
}

test('a user follows and unfollows another', function () {
    $me = User::factory()->create();
    $other = User::factory()->create();

    $followId = followRequest($me, $other->id)
        ->assertCreated()
        ->assertJsonPath('data.attributes.followable_id', $other->id)
        ->assertJsonPath('data.attributes.user_id', $me->id)
        ->json('data.id');
    followRequest($me, $other->id)->assertUnprocessable();
    expect($me->isFollowing($other))->toBeTrue();

    actingAsNative($me)->getJson("/api/follows?filter[followable_id]={$other->id}&include=followable", jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.0.id', $followId)
        ->assertJsonPath('included.0.id', $other->id);

    actingAsNative($me)->getJson("/api/users/{$other->id}", jsonApiHeaders())
        ->assertJsonPath('data.attributes.followers_count', 1)
        ->assertJsonPath('data.attributes.following_count', 0)
        ->assertJsonPath('data.attributes.is_followed_by_me', true)
        ->assertJsonPath('data.attributes.follows_me', false);
    actingAsNative($other)->getJson("/api/users/{$me->id}", jsonApiHeaders())
        ->assertJsonPath('data.attributes.follows_me', true);

    actingAsNative($other)->deleteJson("/api/follows/{$followId}", [], jsonApiHeaders())->assertNotFound();
    actingAsNative($me)->deleteJson("/api/follows/{$followId}", [], jsonApiHeaders())->assertNoContent();
    expect($me->isFollowing($other))->toBeFalse();
});

test('some follows are refused', function () {
    $me = User::factory()->create();
    $private = User::factory()->create(['visibility' => Visibility::Private]);
    $blocker = User::factory()->create();
    $blocked = User::factory()->create();
    UserBlock::create(['user_id' => $blocker->id, 'blocked_id' => $me->id]);
    UserBlock::create(['user_id' => $me->id, 'blocked_id' => $blocked->id]);

    followRequest($me, $me->id)->assertUnprocessable()->assertJsonPath('errors.0.code', 'cannot_follow_self');
    followRequest($me, $private->id)->assertForbidden()->assertJsonPath('errors.0.code', 'profile_private');
    followRequest($me, $blocker->id)->assertForbidden()->assertJsonPath('errors.0.code', 'user_blocked');
    followRequest($me, $blocked->id)->assertForbidden()->assertJsonPath('errors.0.code', 'user_blocked');
    followRequest($me, '00000000-0000-0000-0000-000000000000')->assertUnprocessable();

    expect(DB::table('followables')->count())->toBe(0);
});

test('a follow survives the profile turning private, but shows nothing', function () {
    $me = User::factory()->create();
    $other = User::factory()->create();
    $me->follow($other);
    $other->update(['visibility' => Visibility::Private]);

    expect($me->isFollowing($other))->toBeTrue();
    actingAsNative($me)->getJson("/api/users/{$other->id}/followers", jsonApiHeaders())
        ->assertForbidden()->assertJsonPath('errors.0.code', 'profile_private');
    actingAsNative($me)->getJson("/api/users/{$other->id}", jsonApiHeaders())
        ->assertJsonMissingPath('data.attributes.followers_count');
});

test('followers and following are listed without one query per user', function () {
    $star = User::factory()->create();
    $fans = User::factory()->count(4)->create();
    $fans->each(fn (User $fan) => $fan->follow($star));
    $star->follow($fans[0]);
    $viewer = User::factory()->create();

    DB::enableQueryLog();
    expect(userIds($viewer, "/api/users/{$star->id}/followers"))->toEqualCanonicalizing($fans->pluck('id')->all());
    expect(count(DB::getQueryLog()))->toBeLessThan(8);

    expect(userIds($viewer, "/api/users/{$star->id}/following"))->toBe([$fans[0]->id]);
    actingAsNative($viewer)->getJson("/api/users/{$star->id}/followers", jsonApiHeaders())
        ->assertJsonStructure(['meta' => ['totalItems']])
        ->assertJsonPath('data.0.attributes.following_count', 1);
});

test('blocking ends follows both ways and hides each user from the other', function () {
    $me = User::factory()->create();
    $other = User::factory()->create(['nickname' => 'findme']);
    $me->follow($other);
    $other->follow($me);
    LibraryEntry::create(['user_id' => $other->id, 'game_id' => 1, 'status' => LibraryEntryStatus::Playing, 'owned' => true]);
    GameList::factory()->for($other)->create();

    blockRequest($me, $other->id)->assertCreated();
    blockRequest($me, $other->id)->assertUnprocessable();
    expect(DB::table('followables')->count())->toBe(0);

    foreach ([[$me, $other], [$other, $me]] as [$viewer, $target]) {
        foreach ([
            "/api/users/{$target->id}",
            "/api/library_entries?filter[user]={$target->id}",
            "/api/lists?filter[user]={$target->id}",
            "/api/users/{$target->id}/followers",
            "/api/users/{$target->id}/stats",
            "/api/activities?filter[user]={$target->id}",
        ] as $uri) {
            actingAsNative($viewer)->getJson($uri, jsonApiHeaders())
                ->assertForbidden()
                ->assertJsonPath('errors.0.code', 'user_blocked');
        }
    }

    expect(userIds(User::factory()->create(), '/api/users?filter[search]=findme'))->toBe([$other->id])
        ->and(userIds($me, '/api/users?filter[search]=findme'))->toBe([]);
});

test('blocked users are listed and can be unblocked', function () {
    $me = User::factory()->create();
    $blocked = User::factory()->create(['bio' => 'hidden']);
    $blockId = blockRequest($me, $blocked->id)->assertCreated()->json('data.id');

    actingAsNative($me)->getJson('/api/blocks?include=blocked', jsonApiHeaders())
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.attributes.blocked_id', $blocked->id)
        ->assertJsonPath('included.0.id', $blocked->id)
        ->assertJsonMissingPath('included.0.attributes.bio');
    actingAsNative($blocked)->getJson('/api/blocks', jsonApiHeaders())->assertJsonCount(0, 'data');
    actingAsNative(User::factory()->create())->getJson("/api/users/{$me->id}", jsonApiHeaders())
        ->assertJsonMissingPath('data.relationships.blocks');
    actingAsNative($blocked)->deleteJson("/api/blocks/{$blockId}", [], jsonApiHeaders())->assertNotFound();

    actingAsNative($me)->deleteJson("/api/blocks/{$blockId}", [], jsonApiHeaders())->assertNoContent();
    actingAsNative($me)->getJson('/api/blocks', jsonApiHeaders())->assertJsonCount(0, 'data');
    actingAsNative($me)->getJson("/api/users/{$blocked->id}", jsonApiHeaders())->assertOk();

    blockRequest($me, $me->id)->assertUnprocessable()->assertJsonPath('errors.0.code', 'cannot_block_self');
});

test('follower lists leave out users in a block with the viewer', function () {
    $star = User::factory()->create();
    $fan = User::factory()->create();
    $blockedFan = User::factory()->create();
    $fan->follow($star);
    $blockedFan->follow($star);
    $viewer = User::factory()->create();
    UserBlock::create(['user_id' => $blockedFan->id, 'blocked_id' => $viewer->id]);

    expect(userIds($viewer, "/api/users/{$star->id}/followers"))->toBe([$fan->id]);
});

test('social actions need authentication and the profile ability', function () {
    $other = User::factory()->create();

    $this->postJson('/api/follows', [], jsonApiHeaders())->assertUnauthorized();
    actingAsNative(User::factory()->create(), ['library'])->postJson('/api/blocks', [
        'data' => ['type' => 'Block', 'attributes' => ['blocked_id' => $other->id]],
    ], jsonApiHeaders())->assertForbidden();
});

test('a profile update answers with the same follow figures as a read', function () {
    $me = User::factory()->create();
    $fan = User::factory()->create();
    $fan->follow($me);

    actingAsNative($me)->patchJson("/api/users/{$me->id}", [
        'data' => ['type' => 'User', 'id' => $me->id, 'attributes' => ['bio' => 'x']],
    ], jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.attributes.followers_count', 1)
        ->assertJsonPath('data.attributes.following_count', 0)
        ->assertJsonPath('data.attributes.is_followed_by_me', false)
        ->assertJsonPath('data.attributes.follows_me', false);
});
