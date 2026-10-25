<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Laravel\Eloquent\Filter\EqualsFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\QueryParameter;
use App\Http\Requests\ReactionRequest;
use App\Observers\ReactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Qirolab\Laravel\Reactions\Models\Reaction as PackageReaction;

/**
 * The caller's reaction to a review, a list or a comment. A like is the `like` reaction, the
 * only one reviews and lists accept; comments accept any single emoji too.
 *
 * @property LibraryEntry|GameList|Comment $reactable
 */
#[ObservedBy(ReactionObserver::class)]
#[ApiResource(
    description: "The caller's reaction to a review, a list or a comment.",
    operations: [
        new GetCollection,
        new Get,
        new Post,
        new Patch,
        new Delete,
    ],
    rules: ReactionRequest::class
)]
#[ApiProperty(description: 'What is reacted to: library_entry, list or comment.', property: 'reactable_type')]
#[ApiProperty(property: 'reactable_id')]
#[ApiProperty(description: '"like", or for comments a single emoji.', property: 'type')]
#[ApiProperty(description: 'Who reacted, always the caller.', property: 'user_id', writable: false)]
#[ApiProperty(property: 'reactable', writable: false)]
#[ApiProperty(property: 'user', readable: false, writable: false)]
#[ApiProperty(property: 'react_by', readable: false, writable: false)]
#[QueryParameter('filter[reactable_type]', filter: EqualsFilter::class, property: 'reactable_type', description: 'With filter[reactable_id], the caller\'s reaction to that subject', constraints: ['in:library_entry,list,comment'])]
#[QueryParameter('filter[reactable_id]', filter: EqualsFilter::class, property: 'reactable_id', constraints: ['integer', 'min:1'])]
class Reaction extends PackageReaction
{
    public const string LIKE = 'like';

    protected $hidden = ['id'];

    protected $fillable = ['reactable_type', 'reactable_id', 'type'];

    /**
     * The reactor is the caller (see LibraryEntry).
     */
    protected static function booted(): void
    {
        static::creating(static function (self $reaction): void {
            if (auth()->check()) {
                $reaction->user_id = auth()->id();
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['reactable_id' => 'integer'];
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function reactable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
