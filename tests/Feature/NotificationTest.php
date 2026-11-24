<?php

declare(strict_types=1);

use App\Enums\LibraryEntryStatus;
use App\Enums\Visibility;
use App\Models\Activity;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\User;
use App\Models\UserBlock;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * @return list<array<string, mixed>>
 */
function notificationsOf(User $user, string $query = ''): array
{
    return collect(actingAsNative($user)->getJson("/api/notifications?$query", jsonApiHeaders())->assertOk()->json('data'))
        ->map(static fn (array $notification): array => ['type' => $notification['attributes']['type']] + $notification['attributes']['data'])
        ->all();
}

/**
 * @param  array<string, mixed>  $attributes
 */
function post(User $user, string $uri, string $type, array $attributes): int|string
{
    return actingAsNative($user)->postJson($uri, ['data' => ['type' => $type, 'attributes' => $attributes]], jsonApiHeaders())
        ->assertCreated()
        ->json('data.id');
}

test('likes, comments, replies, reactions and follows notify their recipient', function () {
    $owner = User::factory()->create();
    $fan = User::factory()->create(['nickname' => 'fan', 'picture' => 'https://example.test/fan.png']);
    $entry = LibraryEntry::create(['user_id' => $owner->id, 'game_id' => 42, 'status' => LibraryEntryStatus::Completed, 'owned' => true, 'review' => 'Great']);
    $list = GameList::factory()->for($owner)->create(['name' => 'Top']);

    post($fan, '/api/reactions', 'Reaction', ['reactable_type' => 'library_entry', 'reactable_id' => $entry->id, 'type' => 'like']);
    post($fan, '/api/reactions', 'Reaction', ['reactable_type' => 'list', 'reactable_id' => $list->id, 'type' => 'like']);
    $comment = (int) post($fan, '/api/comments', 'Comment', ['commentable_type' => 'library_entry', 'commentable_id' => $entry->id, 'comment' => 'Hi']);
    post($fan, '/api/comments', 'Comment', ['commentable_type' => 'list', 'commentable_id' => $list->id, 'comment' => 'Hi']);
    $reply = (int) post($owner, '/api/comments', 'Comment', ['commentable_type' => 'comment', 'commentable_id' => $comment, 'comment' => 'Thanks']);
    post($owner, '/api/reactions', 'Reaction', ['reactable_type' => 'comment', 'reactable_id' => $comment, 'type' => '❤️']);
    post($fan, '/api/follows', 'Follow', ['followable_id' => $owner->id]);

    $actor = ['id' => $fan->id, 'nickname' => 'fan', 'picture' => 'https://example.test/fan.png'];
    expect(collect(notificationsOf($owner))->map(fn (array $n) => collect($n)->except('reaction_id', 'comment_id')->all())->all())->toEqualCanonicalizing([
        ['type' => 'new_follower', 'actor' => $actor, 'subject_type' => null, 'subject_id' => null],
        ['type' => 'list_commented', 'actor' => $actor, 'subject_type' => 'list', 'subject_id' => $list->id, 'list_name' => 'Top'],
        ['type' => 'review_commented', 'actor' => $actor, 'subject_type' => 'library_entry', 'subject_id' => $entry->id, 'game_id' => 42],
        ['type' => 'list_liked', 'actor' => $actor, 'subject_type' => 'list', 'subject_id' => $list->id, 'list_name' => 'Top'],
        ['type' => 'review_liked', 'actor' => $actor, 'subject_type' => 'library_entry', 'subject_id' => $entry->id, 'game_id' => 42],
    ]);
    expect(collect(notificationsOf($fan))->pluck('type')->all())->toEqualCanonicalizing(['comment_reacted', 'comment_replied'])
        ->and(collect(notificationsOf($fan))->firstWhere('type', 'comment_replied')['comment_id'])->toBe($reply);
});

test('nobody is notified of their own actions', function () {
    $owner = User::factory()->create();
    $entry = LibraryEntry::create(['user_id' => $owner->id, 'game_id' => 1, 'status' => LibraryEntryStatus::Completed, 'owned' => true, 'review' => 'Mine']);

    post($owner, '/api/reactions', 'Reaction', ['reactable_type' => 'library_entry', 'reactable_id' => $entry->id, 'type' => 'like']);
    post($owner, '/api/comments', 'Comment', ['commentable_type' => 'library_entry', 'commentable_id' => $entry->id, 'comment' => 'Me']);

    expect(notificationsOf($owner))->toBe([]);
});

test('notifications are read one by one or all at once, and counted when unread', function () {
    $user = User::factory()->create();
    foreach (User::factory()->count(3)->create() as $follower) {
        post($follower, '/api/follows', 'Follow', ['followable_id' => $user->id]);
    }

    actingAsNative($user)->getJson('/api/notifications?filter[unread]=true', jsonApiHeaders())->assertJsonPath('meta.totalItems', 3);
    $id = actingAsNative($user)->getJson('/api/notifications', jsonApiHeaders())->json('data.0.id');

    actingAsNative($user)->patchJson("/api/notifications/{$id}", ['data' => ['type' => 'Notification', 'attributes' => ['is_read' => true]]], jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.attributes.is_read', true);
    actingAsNative($user)->getJson('/api/notifications?filter[unread]=true', jsonApiHeaders())->assertJsonPath('meta.totalItems', 2);
    actingAsNative($user)->patchJson("/api/notifications/{$id}", ['data' => ['type' => 'Notification', 'attributes' => ['type' => 'x']]], jsonApiHeaders())
        ->assertUnprocessable();

    actingAsNative($user)->postJson('/api/notifications/read-all')->assertNoContent();
    actingAsNative($user)->getJson('/api/notifications?filter[unread]=true', jsonApiHeaders())->assertJsonPath('meta.totalItems', 0);
    actingAsNative($user)->getJson('/api/notifications?filter[unread]=false', jsonApiHeaders())->assertJsonPath('meta.totalItems', 3);

    actingAsNative(User::factory()->create())->getJson("/api/notifications/{$id}", jsonApiHeaders())->assertNotFound();
});

test('taking back a like or deleting a comment takes back its notification', function () {
    $owner = User::factory()->create();
    $fan = User::factory()->create();
    $entry = LibraryEntry::create(['user_id' => $owner->id, 'game_id' => 1, 'status' => LibraryEntryStatus::Completed, 'owned' => true, 'review' => 'Great']);
    $like = post($fan, '/api/reactions', 'Reaction', ['reactable_type' => 'library_entry', 'reactable_id' => $entry->id, 'type' => 'like']);
    $comment = post($fan, '/api/comments', 'Comment', ['commentable_type' => 'library_entry', 'commentable_id' => $entry->id, 'comment' => 'Hi']);

    actingAsNative($fan)->deleteJson("/api/reactions/{$like}", [], jsonApiHeaders())->assertNoContent();
    actingAsNative($fan)->deleteJson("/api/comments/{$comment}", [], jsonApiHeaders())->assertNoContent();

    expect(notificationsOf($owner))->toBe([]);
});

test('a new comment notifies whom it mentions, once each, if they can read it and were not notified already', function () {
    $owner = User::factory()->create(['nickname' => 'Owner']);
    $author = User::factory()->create(['nickname' => 'author', 'picture' => 'https://example.test/p.png']);
    $mentioned = User::factory()->create(['nickname' => 'Mario.Rossi']);
    $blocked = User::factory()->create(['nickname' => 'blocked']);
    UserBlock::create(['user_id' => $blocked->id, 'blocked_id' => $author->id]);
    $entry = LibraryEntry::create(['user_id' => $owner->id, 'game_id' => 1, 'status' => LibraryEntryStatus::Completed, 'owned' => true, 'review' => 'Great']);

    $comment = (int) post($author, '/api/comments', 'Comment', ['commentable_type' => 'library_entry', 'commentable_id' => $entry->id,
        'comment' => '@mario.rossi (@MARIO.ROSSI). @owner @author @blocked @nobody mail@mario.rossi']);

    expect(notificationsOf($mentioned))->toBe([['type' => 'mention', 'actor' => ['id' => $author->id, 'nickname' => 'author', 'picture' => 'https://example.test/p.png'],
        'subject_type' => 'comment', 'subject_id' => $comment, 'comment_id' => $comment]])
        ->and(collect(notificationsOf($owner))->pluck('type')->all())->toBe(['review_commented'])
        ->and(notificationsOf($author))->toBe([])
        ->and(notificationsOf($blocked))->toBe([]);

    $late = User::factory()->create(['nickname' => 'late']);
    actingAsNative($author)->patchJson("/api/comments/{$comment}", ['data' => ['type' => 'Comment', 'attributes' => ['comment' => 'Hi @late']]], jsonApiHeaders())->assertOk();
    expect(notificationsOf($late))->toBe([]);
});

test('a comment notifies at most ten mentioned users, and none who cannot read the thread', function () {
    $author = User::factory()->create(['visibility' => Visibility::Private]);
    $users = collect(range(1, 11))->map(static fn (int $index) => User::factory()->create(['nickname' => sprintf('user%02d', $index)]));
    $entry = LibraryEntry::create(['user_id' => $author->id, 'game_id' => 1, 'status' => LibraryEntryStatus::Completed, 'owned' => true, 'review' => 'Mine']);
    $list = GameList::factory()->for($author)->create(['visibility' => Visibility::Public]);
    $mentions = '@user01 ' . $users->map(static fn (User $user): string => "@{$user->nickname}")->implode(' ');

    post($author, '/api/comments', 'Comment', ['commentable_type' => 'library_entry', 'commentable_id' => $entry->id, 'comment' => $mentions]);
    expect($users->sum(static fn (User $user): int => count(notificationsOf($user))))->toBe(0);

    $author->update(['visibility' => Visibility::Public]);
    post($author, '/api/comments', 'Comment', ['commentable_type' => 'list', 'commentable_id' => $list->id, 'comment' => $mentions]);
    expect($users->map(static fn (User $user): int => count(notificationsOf($user)))->all())->toBe([...array_fill(0, 10, 1), 0]);
});

test('followers are told what a followed user completed, reviewed or listed, if they can see it', function () {
    Cache::put('igdb_cache.access_token', 'test-token');
    Http::fake(['api.igdb.com/v4/games' => Http::response([['id' => 42, 'name' => 'Doom']])]);
    $author = User::factory()->create(['nickname' => 'author', 'picture' => 'https://example.test/p.png']);
    [$follower, $stranger] = User::factory()->count(2)->create();
    $follower->follow($author);

    $entry = LibraryEntry::create(['user_id' => $author->id, 'game_id' => 42, 'status' => LibraryEntryStatus::Completed, 'owned' => true, 'review' => 'Great']);
    LibraryEntry::create(['user_id' => $author->id, 'game_id' => 7, 'status' => LibraryEntryStatus::Playing, 'owned' => true]);
    actingAsNative($author);
    $list = GameList::factory()->for($author)->create(['name' => 'Top']);
    GameList::factory()->for($author)->private()->create();
    $author->update(['visibility' => Visibility::Private]);
    GameList::factory()->for($author)->create();

    $actor = ['id' => $author->id, 'nickname' => 'author', 'picture' => 'https://example.test/p.png'];
    $activityId = static fn (string $verb): int => Activity::where('verb', $verb)->sole()->id;
    $game = ['subject_type' => 'library_entry', 'subject_id' => $entry->id, 'game_id' => 42, 'game_name' => 'Doom', 'list_name' => null];
    expect(notificationsOf($follower))->toEqualCanonicalizing([
        ['type' => 'followed_user_activity', 'actor' => $actor, 'activity_id' => $activityId('completed'), 'verb' => 'completed', ...$game],
        ['type' => 'followed_user_activity', 'actor' => $actor, 'activity_id' => $activityId('reviewed'), 'verb' => 'reviewed', ...$game],
        ['type' => 'followed_user_activity', 'actor' => $actor, 'subject_type' => 'list', 'subject_id' => $list->id,
            'activity_id' => Activity::where('verb', 'list_created')->whereMorphedTo('subject', $list)->sole()->id, 'verb' => 'list_created',
            'game_id' => null, 'game_name' => null, 'list_name' => 'Top'],
    ])->and(notificationsOf($stranger))->toBe([]);

    $entry->delete();
    expect(collect(notificationsOf($follower))->pluck('verb')->all())->toBe(['list_created']);
});

test('earning a badge notifies the user who earned it', function () {
    $user = User::factory()->create(['nickname' => 'me', 'picture' => 'https://example.test/p.png']);

    Activity::create(['user_id' => $user->id, 'verb' => 'badge_earned', 'subject_class' => User::class, 'subject_id' => $user->id, 'payload' => ['badge' => 'first_review']]);

    expect(notificationsOf($user))->toBe([['type' => 'badge_earned', 'actor' => ['id' => $user->id, 'nickname' => 'me', 'picture' => 'https://example.test/p.png'],
        'subject_type' => null, 'subject_id' => null, 'badge' => 'first_review']]);
});
