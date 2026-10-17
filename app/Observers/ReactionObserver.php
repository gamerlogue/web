<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Comment;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\Notification;
use App\Models\Reaction;
use App\Models\User;
use App\Notifications\SocialNotification;

/**
 * Tells the owner of what was liked or reacted to; taking the reaction back takes the
 * notification back.
 */
class ReactionObserver
{
    public function created(Reaction $reaction): void
    {
        $target = $reaction->reactable;
        [$type, $recipientId, $extra] = match (true) {
            $target instanceof LibraryEntry => ['review_liked', $target->user_id, ['game_id' => $target->game_id]],
            $target instanceof GameList => ['list_liked', $target->user_id, ['list_name' => $target->name]],
            $target instanceof Comment => ['comment_reacted', $target->user_id, ['reaction' => $reaction->type]],
        };

        SocialNotification::send(User::findOrFail($recipientId), $type, User::findOrFail($reaction->user_id), $target, ['reaction_id' => $reaction->id, ...$extra]);
    }

    public function deleted(Reaction $reaction): void
    {
        Notification::where('data->reaction_id', $reaction->id)->delete();
    }
}
