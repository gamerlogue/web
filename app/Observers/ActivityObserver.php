<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Activity;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\User;
use App\Notifications\SocialNotification;
use MariusGelez\IGDBLaravel\Models\Game;

/**
 * Turns some new activities into notifications: a few verbs to the actor's followers, an earned
 * badge to the actor. An activity folded into a recent one is not new and notifies nobody again.
 */
class ActivityObserver
{
    /** The verbs notified to followers as followed_user_activity. */
    public const array FOLLOWER_VERBS = ['completed', 'reviewed', 'list_created'];

    public function created(Activity $activity): void
    {
        if ($activity->verb === 'badge_earned') {
            // The only notification about one's own action, hence not through send().
            $user = User::findOrFail($activity->user_id);
            $user->notify(new SocialNotification('badge_earned', $user, null, ['badge' => $activity->payload['badge']]));

            return;
        }
        if (! in_array($activity->verb, self::FOLLOWER_VERBS, true)) {
            return;
        }

        // Queued: the IGDB lookup and the fan-out stay out of the request that did the thing.
        $activityId = $activity->id;
        dispatch(static fn () => self::notifyFollowers($activityId))->afterCommit();
    }

    /**
     * One notification per follower who can see the subject: a public profile, no block, and for
     * a list a public one. Gone if the activity was deleted before the job ran.
     */
    private static function notifyFollowers(int $activityId): void
    {
        $activity = Activity::find($activityId);
        /** @var LibraryEntry|GameList|null $subject */
        $subject = $activity?->subject;
        if ($subject === null) {
            return;
        }

        $actor = User::findOrFail($activity->user_id);
        // ponytail: loads every follower at once; chunk it if follower counts grow large.
        $followers = User::whereIn('id', $actor->followers()->select('followables.user_id'))->get()->filter(static fn (User $follower): bool => $subject->isVisibleTo($follower));
        if ($followers->isEmpty()) {
            return;
        }

        $gameId = $subject instanceof LibraryEntry ? $subject->game_id : null;
        $extra = [
            'activity_id' => $activity->id,
            'verb' => $activity->verb,
            'game_id' => $gameId,
            'game_name' => $gameId === null ? null : Game::select(['name'])->find($gameId)?->name,
            'list_name' => $subject instanceof GameList ? $subject->name : null,
        ];
        $followers->each(static fn (User $follower) => SocialNotification::send($follower, 'followed_user_activity', $actor, $subject, $extra));
    }
}
