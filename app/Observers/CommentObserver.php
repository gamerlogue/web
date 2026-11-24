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
 * comment replied to; then whoever the comment mentions.
 */
class CommentObserver
{
    /** Mentions past this many distinct nicknames in one comment are ignored. */
    public const int MAX_MENTIONS = 10;

    public function created(Comment $comment): void
    {
        $target = $comment->commentable;
        [$type, $recipientId, $extra] = match (true) {
            $target instanceof LibraryEntry => ['review_commented', $target->user_id, ['game_id' => $target->game_id]],
            $target instanceof GameList => ['list_commented', $target->user_id, ['list_name' => $target->name]],
            $target instanceof Comment => ['comment_replied', $target->user_id, []],
        };

        $author = User::findOrFail($comment->user_id);
        SocialNotification::send(User::findOrFail($recipientId), $type, $author, $target, ['comment_id' => $comment->id, ...$extra]);
        $this->notifyMentioned($comment, $author, $recipientId);
    }

    /**
     * Every distinct `@nickname`, case-insensitive, preceded by nothing or by a non-word character.
     * A nickname may contain `.` and `-` but the handle must not end with them, so the full stop
     * of "thanks @mario." is not part of it. The recipient of the comment's own notification
     * gets only that one.
     */
    private function notifyMentioned(Comment $comment, User $author, string $notifiedId): void
    {
        preg_match_all('/(?<![\pL\pN_])@([\pL\pN_.-]*[\pL\pN_])/u', $comment->comment, $matches);
        $handles = array_slice(array_values(array_unique(array_map(mb_strtolower(...), $matches[1]))), 0, self::MAX_MENTIONS);
        if ($handles === []) {
            return;
        }

        User::whereIn('nickname_key', $handles)->whereKeyNot($notifiedId)->get()
            ->filter(static fn (User $mentioned): bool => $comment->isVisibleTo($mentioned))
            ->each(static fn (User $mentioned) => SocialNotification::send($mentioned, 'mention', $author, $comment, ['comment_id' => $comment->id]));
    }
}
