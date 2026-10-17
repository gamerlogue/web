<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Comment;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\User;
use App\Notifications\SocialNotification;

/**
 * Tells whoever owns what was commented: the review's or list's owner, or the author of the
 * comment replied to.
 */
class CommentObserver
{
    public function created(Comment $comment): void
    {
        $target = $comment->commentable;
        [$type, $recipientId, $extra] = match (true) {
            $target instanceof LibraryEntry => ['review_commented', $target->user_id, ['game_id' => $target->game_id]],
            $target instanceof GameList => ['list_commented', $target->user_id, ['list_name' => $target->name]],
            $target instanceof Comment => ['comment_replied', $target->user_id, []],
        };

        SocialNotification::send(User::findOrFail($recipientId), $type, User::findOrFail($comment->user_id), $target, ['comment_id' => $comment->id, ...$extra]);
    }
}
