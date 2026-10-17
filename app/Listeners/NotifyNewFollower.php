<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\User;
use App\Notifications\SocialNotification;
use Overtrue\LaravelFollow\Events\Followed;

class NotifyNewFollower
{
    public function handle(Followed $event): void
    {
        $followed = User::find($event->followable_id);
        $follower = User::find($event->user_id);
        if ($followed !== null && $follower !== null) {
            SocialNotification::send($followed, 'new_follower', $follower, null, []);
        }
    }
}
