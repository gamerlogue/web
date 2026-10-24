<?php

declare(strict_types=1);

use App\Enums\LibraryEntryStatus;
use App\Enums\Visibility;
use App\Models\Comment;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;

function reviewOf(User $owner, ?string $review = 'Great game'): LibraryEntry
{
    return LibraryEntry::create(['user_id' => $owner->id, 'game_id' => fake()->unique()->numberBetween(1, 99999), 'status' => LibraryEntryStatus::Completed, 'owned' => true, 'review' => $review]);
}

function react(User $user, string $type, int $id, string $reaction): TestResponse
{
    return actingAsNative($user)->postJson('/api/reactions', [
        'data' => ['type' => 'Reaction', 'attributes' => ['reactable_type' => $type, 'reactable_id' => $id, 'type' => $reaction]],
    ], jsonApiHeaders());
}

/**
 * @param  array<string, mixed>  $attributes
 */
function comment(User $user, string $type, int $id, array $attributes = []): TestResponse
{
    return actingAsNative($user)->postJson('/api/comments', [
        'data' => ['type' => 'Comment', 'attributes' => ['commentable_type' => $type, 'commentable_id' => $id, 'comment' => 'Nice', ...$attributes]],
    ], jsonApiHeaders());
}

test('reviews and lists are liked and unliked', function () {
    $owner = User::factory()->create();
    $fan = User::factory()->create();
    $entry = reviewOf($owner);
    $list = GameList::factory()->for($owner)->create();

    $likeId = react($fan, 'library_entry', $entry->id, 'like')->assertCreated()->json('data.id');
    react($fan, 'list', $list->id, 'like')->assertCreated();
    react($fan, 'library_entry', $entry->id, 'like')->assertUnprocessable();

    actingAsNative($fan)->getJson("/api/library_entries?filter[user]={$owner->id}", jsonApiHeaders())
        ->assertJsonPath('data.0.attributes.likes_count', 1)
        ->assertJsonPath('data.0.attributes.liked_by_me', true);
    actingAsNative($owner)->getJson("/api/lists/{$list->id}", jsonApiHeaders())
        ->assertJsonPath('data.attributes.likes_count', 1)
        ->assertJsonPath('data.attributes.liked_by_me', false);
    actingAsNative($fan)->getJson("/api/reactions?filter[reactable_type]=library_entry&filter[reactable_id]={$entry->id}", jsonApiHeaders())
        ->assertJsonPath('data.0.id', $likeId);

    actingAsNative($owner)->deleteJson("/api/reactions/{$likeId}", [], jsonApiHeaders())->assertNotFound();
    actingAsNative($fan)->deleteJson("/api/reactions/{$likeId}", [], jsonApiHeaders())->assertNoContent();
    expect($entry->reactions()->count())->toBe(0);
});

test('likes and comments are refused where they do not belong', function () {
    $owner = User::factory()->create();
    $fan = User::factory()->create();
    $bare = reviewOf($owner, null);
    $privateOwner = User::factory()->create(['visibility' => Visibility::Private]);
    $hidden = reviewOf($privateOwner);
    $privateList = GameList::factory()->for($owner)->private()->create();
    $review = reviewOf($owner);
    $detailsOnly = reviewOf($owner, null);
    $detailsOnly->update(['rating_details' => ['story' => ['rating' => 80, 'review' => '']]]);
    $ratingOnly = reviewOf($owner, null);
    $ratingOnly->update(['rating' => 60]);

    react($fan, 'library_entry', $bare->id, 'like')->assertUnprocessable()->assertJsonPath('errors.0.code', 'review_required');
    comment($fan, 'library_entry', $bare->id)->assertUnprocessable()->assertJsonPath('errors.0.code', 'review_required');
    react($fan, 'library_entry', $hidden->id, 'like')->assertForbidden()->assertJsonPath('errors.0.code', 'profile_private');
    comment($fan, 'library_entry', $hidden->id)->assertForbidden()->assertJsonPath('errors.0.code', 'profile_private');
    react($fan, 'list', $privateList->id, 'like')->assertNotFound();
    react($fan, 'library_entry', $review->id, '🔥')->assertUnprocessable();
    react($fan, 'library_entry', $detailsOnly->id, 'like')->assertCreated();
    react($fan, 'library_entry', $ratingOnly->id, 'like')->assertCreated();
    react($fan, 'list', 999, 'like')->assertUnprocessable();

    actingAsNative($owner)->postJson('/api/blocks', ['data' => ['type' => 'Block', 'attributes' => ['blocked_id' => $fan->id]]], jsonApiHeaders())->assertCreated();
    // In production every request loads its user afresh; here $fan is reused, memoized blocks included.
    $fan->forgetBlockedUserIds();
    react($fan, 'library_entry', $review->id, 'like')->assertForbidden()->assertJsonPath('errors.0.code', 'user_blocked');
    comment($fan, 'library_entry', $review->id)->assertForbidden()->assertJsonPath('errors.0.code', 'user_blocked');
});

test('comments thread to any depth and count their direct replies', function () {
    $owner = User::factory()->create();
    $alice = User::factory()->create();
    $bob = User::factory()->create();
    $entry = reviewOf($owner);

    $root = comment($alice, 'library_entry', $entry->id, ['comment' => 'First', 'spoiler' => true])
        ->assertCreated()
        ->assertJsonPath('data.attributes.spoiler', true)
        ->assertJsonPath('data.attributes.user_id', $alice->id)
        ->assertJsonMissingPath('data.attributes.is_approved')
        ->json('data.id');
    $reply = comment($bob, 'comment', (int) $root, ['comment' => 'Reply'])->assertCreated()->json('data.id');
    comment($alice, 'comment', (int) $reply, ['comment' => 'Deeper'])->assertCreated();

    actingAsNative($bob)->getJson("/api/comments?filter[commentable_type]=library_entry&filter[commentable_id]={$entry->id}&include=user", jsonApiHeaders())
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.attributes.replies_count', 1)
        ->assertJsonPath('data.0.attributes.edited', false);
    actingAsNative($bob)->getJson("/api/comments?filter[commentable_type]=comment&filter[commentable_id]={$reply}", jsonApiHeaders())
        ->assertJsonPath('data.0.attributes.comment', 'Deeper');
    actingAsNative($bob)->getJson("/api/library_entries?filter[user]={$owner->id}", jsonApiHeaders())
        ->assertJsonPath('data.0.attributes.comments_count', 1);

    actingAsNative($bob)->getJson('/api/comments', jsonApiHeaders())->assertUnprocessable();
});

test('profanity is masked when a comment is saved', function () {
    $entry = reviewOf(User::factory()->create());

    $id = comment(User::factory()->create(), 'library_entry', $entry->id, ['comment' => 'Che boss di merda, what the fuck'])
        ->assertCreated()
        ->json('data.id');

    expect(Comment::findOrFail($id)->comment)->toBe('Che boss di *****, what the ****');
});

test('only the author edits a comment', function () {
    $entry = reviewOf(User::factory()->create());
    $author = User::factory()->create();
    $id = comment($author, 'library_entry', $entry->id)->json('data.id');

    $patch = fn (User $user) => actingAsNative($user)->patchJson("/api/comments/{$id}", [
        'data' => ['type' => 'Comment', 'attributes' => ['comment' => 'Edited', 'spoiler' => true]],
    ], jsonApiHeaders());

    $patch($entry->user)->assertNotFound();
    $this->travel(1)->minutes();
    $patch($author)->assertOk()->assertJsonPath('data.attributes.edited', true);
    actingAsNative($author)->patchJson("/api/comments/{$id}", [
        'data' => ['type' => 'Comment', 'attributes' => ['commentable_id' => 5]],
    ], jsonApiHeaders())->assertUnprocessable();
});

test('the author or the content owner deletes a comment and its whole subtree', function () {
    $owner = User::factory()->create();
    $author = User::factory()->create();
    $stranger = User::factory()->create();
    $entry = reviewOf($owner);
    $root = (int) comment($author, 'library_entry', $entry->id)->json('data.id');
    $reply = (int) comment($stranger, 'comment', $root)->json('data.id');
    comment($author, 'comment', $reply)->assertCreated();
    react($stranger, 'comment', $root, '❤️')->assertCreated();

    actingAsNative($stranger)->deleteJson("/api/comments/{$root}", [], jsonApiHeaders())->assertForbidden();
    actingAsNative($owner)->deleteJson("/api/comments/{$root}", [], jsonApiHeaders())->assertNoContent();

    expect(Comment::count())->toBe(0)->and(Reaction::count())->toBe(0);
});

test('comments take any single emoji as reaction, summed per emoji', function () {
    $entry = reviewOf(User::factory()->create());
    $root = (int) comment(User::factory()->create(), 'library_entry', $entry->id)->json('data.id');
    [$a, $b, $c] = User::factory()->count(3)->create();

    react($a, 'comment', $root, '❤️')->assertCreated();
    react($b, 'comment', $root, '❤️')->assertCreated();
    $id = react($c, 'comment', $root, '👍🏽')->assertCreated()->json('data.id');
    react($c, 'comment', $root, 'xd')->assertUnprocessable();
    actingAsNative($c)->patchJson("/api/reactions/{$id}", [
        'data' => ['type' => 'Reaction', 'attributes' => ['type' => '🇮🇹']],
    ], jsonApiHeaders())->assertOk();

    actingAsNative($c)->getJson("/api/comments/{$root}", jsonApiHeaders())
        ->assertJsonPath('data.attributes.reactions_summary', [['type' => '❤️', 'count' => 2], ['type' => '🇮🇹', 'count' => 1]])
        ->assertJsonPath('data.attributes.my_reaction', '🇮🇹');
});

test('clearing a review or deleting content removes its likes and comments', function () {
    $owner = User::factory()->create();
    $fan = User::factory()->create();
    $entry = reviewOf($owner);
    $list = GameList::factory()->for($owner)->create();
    react($fan, 'library_entry', $entry->id, 'like');
    $root = (int) comment($fan, 'library_entry', $entry->id)->json('data.id');
    comment($owner, 'comment', $root);
    react($fan, 'list', $list->id, 'like');
    comment($fan, 'list', $list->id);

    actingAsNative($owner)->patchJson("/api/library_entries/{$entry->id}", [
        'data' => ['type' => 'LibraryEntry', 'attributes' => ['review' => '', 'rating' => 60]],
    ], jsonApiHeaders())->assertOk();
    expect(Comment::count())->toBe(3)->and(Reaction::count())->toBe(2);

    actingAsNative($owner)->patchJson("/api/library_entries/{$entry->id}", [
        'data' => ['type' => 'LibraryEntry', 'attributes' => ['rating_details' => ['story' => ['rating' => 80, 'review' => '']], 'rating' => null]],
    ], jsonApiHeaders())->assertOk();
    expect(Comment::count())->toBe(3)->and(Reaction::count())->toBe(2);

    actingAsNative($owner)->patchJson("/api/library_entries/{$entry->id}", [
        'data' => ['type' => 'LibraryEntry', 'attributes' => ['rating_details' => null]],
    ], jsonApiHeaders())->assertOk();
    expect(Comment::count())->toBe(1)->and(Reaction::count())->toBe(1);

    actingAsNative($owner)->deleteJson("/api/lists/{$list->id}", [], jsonApiHeaders())->assertNoContent();
    expect(Comment::count())->toBe(0)->and(Reaction::count())->toBe(0);
});

test('comments by users in a block with the viewer are hidden but those of private profiles show', function () {
    $owner = User::factory()->create();
    $viewer = User::factory()->create();
    $blocker = User::factory()->create();
    $private = User::factory()->create(['visibility' => Visibility::Private, 'bio' => 'secret']);
    $entry = reviewOf($owner);
    comment($blocker, 'library_entry', $entry->id, ['comment' => 'hidden']);
    comment($private, 'library_entry', $entry->id, ['comment' => 'shown']);
    actingAsNative($blocker)->postJson('/api/blocks', ['data' => ['type' => 'Block', 'attributes' => ['blocked_id' => $viewer->id]]], jsonApiHeaders());

    $response = actingAsNative($viewer)->getJson("/api/comments?filter[commentable_type]=library_entry&filter[commentable_id]={$entry->id}&include=user", jsonApiHeaders())
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.attributes.comment', 'shown');

    expect($response->json('included.0.attributes'))->not->toHaveKey('bio');
});

test('comments list without one query per comment', function () {
    $entry = reviewOf(User::factory()->create());
    $users = User::factory()->count(5)->create();
    foreach ($users as $user) {
        $id = (int) comment($user, 'library_entry', $entry->id)->json('data.id');
        react($users[0], 'comment', $id, '❤️');
        comment($users[1], 'comment', $id);
    }

    DB::enableQueryLog();
    actingAsNative($users[2])->getJson("/api/comments?filter[commentable_type]=library_entry&filter[commentable_id]={$entry->id}&include=user", jsonApiHeaders())
        ->assertOk()
        ->assertJsonCount(5, 'data');

    expect(count(DB::getQueryLog()))->toBeLessThan(15);
});

test('comments can be reported', function () {
    $entry = reviewOf(User::factory()->create());
    $id = comment(User::factory()->create(), 'library_entry', $entry->id)->json('data.id');

    actingAsNative(User::factory()->create())->postJson('/api/reports', [
        'data' => ['type' => 'Report', 'attributes' => ['reportable_type' => 'comment', 'reportable_id' => (string) $id, 'reason' => 'spoiler']],
    ], jsonApiHeaders())->assertCreated();
});
