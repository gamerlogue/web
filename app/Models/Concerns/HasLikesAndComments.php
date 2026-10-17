<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\Comment;
use App\Models\Reaction;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Likes (the `like` reaction) and comments on a review or a list, with their counters.
 */
trait HasLikesAndComments
{
    use HasComments;
    use HasInteractions;

    /**
     * likes_count, liked_by_me and comments_count in subqueries. Comments by users in a block with
     * the caller are hidden from them, so they are not counted either.
     *
     * @param  Builder<static>  $query
     */
    public function scopeWithInteractionCounts(Builder $query): void
    {
        $viewer = auth()->user();
        $query->withCount([
            'reactions as likes_count' => static fn (Builder $reactions) => $reactions->where('type', Reaction::LIKE),
            'comments as comments_count' => static fn (Builder $comments) => $comments->whereNotIn('user_id', $viewer?->blockedUserIds() ?? []),
        ])->withExists([
            'reactions as liked_by_me' => static fn (Builder $reactions) => $reactions->where('user_id', $viewer?->id),
        ]);
    }

    /**
     * Deletes what others did on this content: comments (one by one, replies and all), likes and
     * the notifications about it.
     */
    public function forgetCommunity(): void
    {
        $this->comments()->get()->each(static fn (Comment $comment) => $comment->delete());
        $this->forgetInteractions();
    }

    /**
     * The three counters come from withInteractionCounts(); these only cover a model loaded
     * without it, such as a write response.
     *
     * @return Attribute<int, never>
     */
    protected function likesCount(): Attribute
    {
        return Attribute::get(fn (?int $value): int => $value ?? $this->reactions()->where('type', Reaction::LIKE)->count());
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function likedByMe(): Attribute
    {
        return Attribute::get(fn (mixed $value): bool => $value === null
            ? $this->reactions()->where('user_id', auth()->id())->exists()
            : (bool) $value);
    }

    /**
     * @return Attribute<int, never>
     */
    protected function commentsCount(): Attribute
    {
        return Attribute::get(fn (?int $value): int => $value ?? $this->comments()->count());
    }
}
