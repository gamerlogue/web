<?php

declare(strict_types=1);

use App\Enums\LibraryEntryStatus;
use App\Models\Activity;
use App\Models\Comment;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\Notification;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * A user with something of every kind, and another one interacting with them.
 *
 * @return array{User, User}
 */
function busyUsers(): array
{
    $user = User::factory()->create(['email' => 'me@example.test']);
    $friend = User::factory()->create();
    $entry = LibraryEntry::create(['user_id' => $user->id, 'game_id' => 7, 'status' => LibraryEntryStatus::Completed, 'owned' => true, 'review' => 'Great']);
    $theirs = LibraryEntry::create(['user_id' => $friend->id, 'game_id' => 8, 'status' => LibraryEntryStatus::Completed, 'owned' => true, 'review' => 'Fine']);
    $list = GameList::factory()->for($user)->create();
    $post = static fn (User $as, string $uri, string $type, array $attributes) => actingAsNative($as)
        ->postJson($uri, ['data' => ['type' => $type, 'attributes' => $attributes]], jsonApiHeaders())->assertCreated()->json('data.id');

    $post($user, '/api/list_items', 'ListItem', ['list_id' => $list->id, 'game_id' => 9]);
    $post($user, '/api/follows', 'Follow', ['followable_id' => $friend->id]);
    $post($friend, '/api/follows', 'Follow', ['followable_id' => $user->id]);
    $mine = (int) $post($user, '/api/comments', 'Comment', ['commentable_type' => 'library_entry', 'commentable_id' => $theirs->id, 'comment' => 'Mine']);
    $post($friend, '/api/comments', 'Comment', ['commentable_type' => 'comment', 'commentable_id' => $mine, 'comment' => 'Reply']);
    $post($friend, '/api/comments', 'Comment', ['commentable_type' => 'library_entry', 'commentable_id' => $entry->id, 'comment' => 'On yours']);
    $post($user, '/api/reactions', 'Reaction', ['reactable_type' => 'library_entry', 'reactable_id' => $theirs->id, 'type' => 'like']);
    $user->createToken('native', ['profile']);

    return [$user, $friend];
}

test('deleting the account removes the user and everything hanging off them', function () {
    [$user, $friend] = busyUsers();
    DB::table('sessions')->insert(['id' => 'web-session', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()]);

    actingAsNative($user)->deleteJson('/api/account')->assertNoContent();

    expect(User::withTrashed()->find($user->id))->toBeNull()
        ->and(LibraryEntry::where('user_id', $user->id)->count())->toBe(0)
        ->and(GameList::count())->toBe(0)
        ->and(DB::table('list_items')->count())->toBe(0)
        ->and(DB::table('followables')->count())->toBe(0)
        // The friend's comment on the user's review and reply to the user's comment go too.
        ->and(Comment::count())->toBe(0)
        ->and(Reaction::count())->toBe(0)
        ->and(DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->count())->toBe(0)
        ->and(DB::table('sessions')->where('user_id', $user->id)->count())->toBe(0)
        ->and(Notification::where('notifiable_id', $user->id)->count())->toBe(0)
        ->and(Notification::where('data->actor->id', $user->id)->count())->toBe(0)
        ->and(Activity::where('user_id', $user->id)->count())->toBe(0)
        ->and(Activity::where('subject_class', User::class)->where('subject_id', $user->id)->count())->toBe(0);

    expect(User::find($friend->id))->not->toBeNull()
        ->and(LibraryEntry::where('user_id', $friend->id)->count())->toBe(1);
});

test('the export holds the users data', function () {
    [$user, $friend] = busyUsers();

    $export = actingAsNative($user)->getJson('/api/account/export')
        ->assertOk()
        ->assertHeader('Content-Disposition', 'attachment; filename="gamerlogue-export.json"')
        ->json();

    expect($export['profile']['email'])->toBe('me@example.test')
        ->and($export['profile'])->not->toHaveKey('password')
        ->and($export['library'])->toHaveCount(1)
        ->and($export['lists'][0]['items'])->toHaveCount(1)
        ->and(collect($export['comments'])->pluck('comment')->all())->toBe(['Mine'])
        ->and($export['reactions'])->toHaveCount(1)
        ->and($export['following'])->toBe([$friend->id])
        ->and($export['followers'])->toBe([$friend->id]);
});

test('account actions need the profile ability', function () {
    $user = User::factory()->create();

    actingAsNative($user, ['library'])->deleteJson('/api/account')->assertForbidden();
    actingAsNative($user, ['library'])->getJson('/api/account/export')->assertForbidden();
    expect(User::find($user->id))->not->toBeNull();
});
