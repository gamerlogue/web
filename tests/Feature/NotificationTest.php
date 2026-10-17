<?php

declare(strict_types=1);

use App\Enums\LibraryEntryStatus;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\User;

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
