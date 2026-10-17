<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\Activity;
use App\Models\User;
use Overtrue\LaravelFollow\Events\Followed;
use Overtrue\LaravelFollow\Events\Unfollowed;

/**
 * "A followed B" exists only while A follows B.
 */
class RecordFollowActivity
{
    public function handle(Followed|Unfollowed $event): void
    {
        $followed = User::find($event->followable_id);
        if ($followed === null) {
            return;
        }

        if ($event instanceof Followed) {
            Activity::record((string) $event->user_id, 'followed', $followed, ['nickname' => $followed->nickname]);

            return;
        }

        Activity::where('user_id', $event->user_id)->where('verb', 'followed')->whereMorphedTo('subject', $followed)->delete();
    }
}
