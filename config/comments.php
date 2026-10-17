<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\User;

return [
    'comment_class' => Comment::class,
    'user_model' => User::class,
    // Comment deletes its own replies one by one, so that each reply's own cascade runs too.
    'delete_replies_along_comments' => false,
];
