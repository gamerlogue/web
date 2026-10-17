<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * The author, or the owner of the review or list the thread is about.
     */
    public function delete(User $viewer, Comment $comment): bool
    {
        return $comment->user_id === $viewer->id || $comment->root()->user_id === $viewer->id;
    }
}
