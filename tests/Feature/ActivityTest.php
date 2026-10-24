<?php

declare(strict_types=1);

use App\Enums\Visibility;
use App\Models\Activity;
use App\Models\GameList;
use App\Models\ListItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * @param  array<string, mixed>  $attributes
 * @param  array<string, string>  $headers
 */
function postEntry(User $user, array $attributes, array $headers = []): string
{
    return actingAsNative($user)->postJson('/api/library_entries', [
        'data' => ['type' => 'LibraryEntry', 'attributes' => ['status' => 'PLAYING', 'owned' => true, ...$attributes]],
    ], [...jsonApiHeaders(), ...$headers])->assertCreated()->json('data.id');
}

/**
 * @param  array<string, mixed>  $attributes
 */
function patchEntry(User $user, string $id, array $attributes): void
{
    actingAsNative($user)->patchJson("/api/library_entries/{$id}", [
        'data' => ['type' => 'LibraryEntry', 'attributes' => $attributes],
    ], jsonApiHeaders())->assertOk();
}

/**
 * @return list<array<string, mixed>>
 */
function activities(User $viewer, string $query = ''): array
{
    return collect(actingAsNative($viewer)->getJson("/api/activities?$query", jsonApiHeaders())->assertOk()->json('data'))
        ->map(static fn (array $activity): array => ['verb' => $activity['attributes']['verb']] + $activity['attributes']['payload'])
        ->all();
}

test('library writes become activities', function () {
    $user = User::factory()->create();
    $id = postEntry($user, ['game_id' => 7, 'rating' => 70]);
    patchEntry($user, $id, ['status' => 'COMPLETED', 'completion_status' => 'MAIN_STORY', 'review' => 'Great']);

    expect(activities($user))->toEqualCanonicalizing([
        ['verb' => 'library_added', 'game_id' => 7, 'status' => 'PLAYING'],
        ['verb' => 'rated', 'game_id' => 7, 'rating' => 70],
        ['verb' => 'status_changed', 'game_id' => 7, 'old' => 'PLAYING', 'new' => 'COMPLETED'],
        ['verb' => 'completed', 'game_id' => 7, 'completion_status' => 'MAIN_STORY'],
        ['verb' => 'reviewed', 'game_id' => 7, 'review_spoiler' => false],
    ]);
});

test('rating details alone are a review, and so are reviewed', function () {
    $user = User::factory()->create();
    $id = postEntry($user, ['game_id' => 7]);
    patchEntry($user, $id, ['rating_details' => ['story' => ['rating' => 80, 'review' => '']]]);

    expect(activities($user))->toContain(['verb' => 'reviewed', 'game_id' => 7, 'review_spoiler' => false]);
});

test('a rating alone is rated, not reviewed', function () {
    $user = User::factory()->create();
    postEntry($user, ['game_id' => 7, 'rating' => 70]);

    expect(collect(activities($user))->pluck('verb')->all())->toEqualCanonicalizing(['library_added', 'rated']);
});

test('repeating a verb on the same subject folds into one activity until the window closes', function () {
    $user = User::factory()->create();
    $id = postEntry($user, ['game_id' => 7]);

    patchEntry($user, $id, ['status' => 'PAUSED']);
    $this->travel(Activity::GROUPING_MINUTES - 1)->minutes();
    patchEntry($user, $id, ['status' => 'ABANDONED']);

    expect(Activity::where('verb', 'status_changed')->sole()->payload)->toBe(['old' => 'PLAYING', 'game_id' => 7, 'new' => 'ABANDONED']);

    $this->travel(Activity::GROUPING_MINUTES + 1)->minutes();
    patchEntry($user, $id, ['status' => 'PLAYING']);
    expect(Activity::where('verb', 'status_changed')->count())->toBe(2);
});

test('an import records a single activity per batch', function () {
    $user = User::factory()->create();
    foreach ([1, 2, 3] as $gameId) {
        $id = postEntry($user, ['game_id' => $gameId, 'rating' => 50], ['X-Library-Import' => 'sync-1']);
    }
    actingAsNative($user)->patchJson("/api/library_entries/{$id}", [
        'data' => ['type' => 'LibraryEntry', 'attributes' => ['status' => 'COMPLETED']],
    ], [...jsonApiHeaders(), 'X-Library-Import' => 'sync-1'])->assertOk();
    postEntry($user, ['game_id' => 4], ['X-Library-Import' => 'sync-2']);

    expect(activities($user))->toBe([
        ['verb' => 'library_imported', 'batch' => 'sync-2', 'count' => 1],
        ['verb' => 'library_imported', 'batch' => 'sync-1', 'count' => 3],
    ]);

    actingAsNative($user)->postJson('/api/library_entries', [
        'data' => ['type' => 'LibraryEntry', 'attributes' => ['game_id' => 5, 'status' => 'PLAYING', 'owned' => true]],
    ], [...jsonApiHeaders(), 'X-Library-Import' => 'not a batch!'])
        ->assertUnprocessable()
        ->assertJsonPath('errors.0.code', 'invalid_import_batch');
});

test('lists, games added to them and follows become activities', function () {
    $user = User::factory()->create();
    $other = User::factory()->create(['nickname' => 'friend']);
    actingAsNative($user);
    $list = GameList::factory()->for($user)->create(['name' => 'Top']);
    ListItem::factory()->for($list, 'list')->create(['game_id' => 1]);
    ListItem::factory()->for($list, 'list')->create(['game_id' => 2]);
    $user->follow($other);

    expect(activities($user))->toEqualCanonicalizing([
        ['verb' => 'list_created', 'name' => 'Top'],
        ['verb' => 'list_item_added', 'name' => 'Top', 'game_ids' => [1, 2]],
        ['verb' => 'followed', 'nickname' => 'friend'],
    ]);

    $user->unfollow($other);
    $list->delete();
    expect(Activity::count())->toBe(0);
});

test('deleting an entry removes its activities', function () {
    $user = User::factory()->create();
    $id = postEntry($user, ['game_id' => 7, 'rating' => 70]);

    actingAsNative($user)->deleteJson("/api/library_entries/{$id}", [], jsonApiHeaders())->assertNoContent();

    expect(Activity::count())->toBe(0);
});

test('a profile shows its activities only to who may see the profile', function () {
    $owner = User::factory()->create();
    postEntry($owner, ['game_id' => 1]);
    actingAsNative($owner);
    GameList::factory()->for($owner)->private()->create();
    $viewer = User::factory()->create();

    expect(collect(activities($viewer, "filter[user]={$owner->id}"))->pluck('verb')->all())->toBe(['library_added'])
        ->and(collect(activities($owner, "filter[user]={$owner->id}"))->pluck('verb')->all())->toEqualCanonicalizing(['library_added', 'list_created']);

    $owner->update(['visibility' => Visibility::Private]);
    actingAsNative($viewer)->getJson("/api/activities?filter[user]={$owner->id}", jsonApiHeaders())
        ->assertForbidden()->assertJsonPath('errors.0.code', 'profile_private');
    expect(Activity::where('user_id', $owner->id)->count())->toBe(2);
});

test('the feed holds the activities of followed public profiles outside blocks', function () {
    $me = User::factory()->create();
    [$friend, $private, $blocker, $stranger] = User::factory()->count(4)->create();
    foreach ([$friend, $private, $blocker] as $followed) {
        $me->follow($followed);
    }
    foreach ([$friend, $private, $blocker, $stranger] as $index => $author) {
        postEntry($author, ['game_id' => $index + 1]);
    }
    $private->update(['visibility' => Visibility::Private]);
    // Through the API: the block takes its blocker from the authenticated user.
    actingAsNative($blocker)->postJson('/api/blocks', [
        'data' => ['type' => 'Block', 'attributes' => ['blocked_id' => $me->id]],
    ], jsonApiHeaders())->assertCreated();
    // Someone the friend follows but who blocked me does not show up through the friend.
    $friend->follow($blocker);

    expect(activities($me, 'filter[feed]=true&sort=-created_at'))->toBe([
        ['verb' => 'library_added', 'game_id' => 1, 'status' => 'PLAYING'],
    ]);
});

test('activities include their user and subject without one query per activity', function () {
    $me = User::factory()->create();
    $friend = User::factory()->create();
    $me->follow($friend);
    foreach (range(1, 5) as $gameId) {
        postEntry($friend, ['game_id' => $gameId]);
    }
    actingAsNative($friend);
    GameList::factory()->for($friend)->count(3)->create();

    DB::enableQueryLog();
    $response = actingAsNative($me)->getJson('/api/activities?filter[feed]=true&include=user,subject', jsonApiHeaders())->assertOk();

    expect($response->json('data'))->toHaveCount(8)
        ->and(collect($response->json('included'))->pluck('type')->unique()->sort()->values()->all())->toBe(['LibraryEntry', 'List', 'User'])
        ->and(count(DB::getQueryLog()))->toBeLessThan(15);
});
