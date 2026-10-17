<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Laravel\Eloquent\Filter\JsonApi\SortFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\QueryParameter;
use App\Exceptions\ApiDomainException;
use App\Http\Requests\CommentRequest;
use App\Models\Concerns\HasInteractions;
use App\Observers\CommentObserver;
use BeyondCode\Comments\Comment as PackageComment;
use Blaspsoft\Blasp\Facades\Blasp;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Symfony\Component\TypeInfo\Type\BuiltinType;
use Symfony\Component\TypeInfo\TypeIdentifier;

/**
 * A comment on a review (library entry), a list, or another comment: a reply is a comment on a
 * comment, to any depth. Always published; profanity is masked when saved.
 */
#[ObservedBy(CommentObserver::class)]
#[ApiResource(
    description: 'A comment on a review, a list, or another comment.',
    operations: [
        // Only the collection requires the target: on the class they would apply to every operation.
        new GetCollection(order: ['created_at' => 'ASC', 'id' => 'ASC'], parameters: [
            'filter[commentable_type]' => new QueryParameter(description: 'Required: library_entry, list, or comment for the replies of a comment', required: true, constraints: ['in:library_entry,list,comment']),
            'filter[commentable_id]' => new QueryParameter(description: 'Required: the id of what is commented', required: true, constraints: ['integer', 'min:1']),
            'sort' => new QueryParameter(filter: SortFilter::class, description: 'Only "created_at", the default', properties: ['created_at']),
        ]),
        new Get,
        new Post,
        new Patch,
        new Delete,
    ],
    rules: CommentRequest::class
)]
#[ApiProperty(description: 'The text, at most 2000 characters, with profanity masked.', property: 'comment')]
#[ApiProperty(description: 'Whether the text reveals plot details.', property: 'spoiler')]
#[ApiProperty(description: 'What is commented: library_entry, list or comment.', property: 'commentable_type')]
#[ApiProperty(property: 'commentable_id')]
#[ApiProperty(description: 'The author, always the caller on creation.', property: 'user_id', writable: false)]
#[ApiProperty(description: 'Whether the text changed after posting.', property: 'edited', writable: false)]
#[ApiProperty(description: 'How many direct replies the comment has.', property: 'replies_count', writable: false)]
#[ApiProperty(description: 'How many users reacted with each emoji, most used first.', property: 'reactions_summary', writable: false, nativeType: new BuiltinType(TypeIdentifier::ARRAY))]
#[ApiProperty(description: "The caller's reaction, null without one.", property: 'my_reaction', writable: false)]
#[ApiProperty(property: 'user', writable: false)]
#[ApiProperty(property: 'commentable', writable: false)]
#[ApiProperty(property: 'comments', readable: false, writable: false)]
#[ApiProperty(property: 'commentator', readable: false, writable: false)]
#[ApiProperty(property: 'reactions', readable: false, writable: false)]
#[ApiProperty(property: 'reaction_counts', readable: false, writable: false)]
class Comment extends PackageComment
{
    use HasInteractions;

    protected $hidden = ['id', 'is_approved'];

    protected $fillable = ['commentable_type', 'commentable_id', 'comment', 'spoiler'];

    /**
     * The author is the caller (see LibraryEntry). Nothing waits for approval, and the text is
     * stored with its profanity masked, in Italian and English.
     *
     * Deleting a comment deletes its replies one by one, so that their own replies, reactions and
     * notifications go too.
     */
    protected static function booted(): void
    {
        static::creating(static function (self $comment): void {
            if (auth()->check()) {
                $comment->user_id = auth()->id();
            }
            $comment->is_approved = true;
        });
        static::saving(static function (self $comment): void {
            if ($comment->isDirty('comment')) {
                $comment->comment = Blasp::in('italian', 'english')->check($comment->comment)->clean();
            }
        });
        static::deleting(static function (self $comment): void {
            $comment->comments()->get()->each->delete();
            $comment->forgetInteractions();
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['is_approved' => 'boolean', 'spoiler' => 'boolean', 'commentable_id' => 'integer'];
    }

    /**
     * A comment shows wherever its thread does, except to users in a block with its author.
     */
    public function ensureVisibleTo(User $viewer): void
    {
        $this->root()->ensureVisibleTo($viewer);
        if ($viewer->isBlockedWith(User::findOrFail($this->user_id))) {
            throw ApiDomainException::userBlocked();
        }
    }

    /**
     * The review or list at the top of the thread.
     */
    public function root(): LibraryEntry|GameList
    {
        $target = $this->commentable;
        while ($target instanceof self) {
            $target = $target->commentable;
        }

        return $target;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function edited(): Attribute
    {
        return Attribute::get(fn (): bool => $this->updated_at?->gt($this->created_at) ?? false);
    }

    /**
     * @return Attribute<int, never>
     */
    protected function repliesCount(): Attribute
    {
        return Attribute::get(fn (?int $value): int => $value ?? $this->comments()->count());
    }

    /**
     * Counted by the query when it eager-loads `reactionCounts`. A list rather than a map: the
     * serializer would turn an empty map into a JSON array anyway, and the order is meaningful.
     *
     * @return Attribute<list<array{type: string, count: int}>, never>
     */
    protected function reactionsSummary(): Attribute
    {
        return Attribute::get(fn (): array => ($this->relationLoaded('reactionCounts') ? $this->reactionCounts : $this->reactionCounts()->get())
            ->map(static fn (Reaction $count): array => ['type' => $count->type, 'count' => (int) $count->getAttribute('total')])
            ->sortByDesc('count')
            ->values()
            ->all());
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function myReaction(): Attribute
    {
        // Selected by the query as a (possibly null) column; queried only when it was not.
        return Attribute::get(fn (?string $value): ?string => array_key_exists('my_reaction', $this->attributes)
            ? $value
            : $this->reactions()->where('user_id', auth()->id())->value('type'));
    }
}
