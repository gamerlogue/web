<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Http\Requests\BlockRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * `user_id` blocked `blocked_id`. Either direction hides each user from the other.
 */
#[ApiResource(
    shortName: 'Block',
    description: 'The caller blocking another user.',
    operations: [
        new GetCollection(uriTemplate: '/blocks'),
        new Get(uriTemplate: '/blocks/{id}'),
        new Post(uriTemplate: '/blocks'),
        new Delete(uriTemplate: '/blocks/{id}'),
    ],
    rules: BlockRequest::class
)]
#[ApiProperty(description: 'The blocked user.', property: 'blocked_id')]
#[ApiProperty(description: 'The blocked user, shown with their public card only.', property: 'blocked', writable: false)]
#[ApiProperty(description: 'The blocker, always the caller.', property: 'user_id', writable: false)]
class UserBlock extends Model
{
    public const null UPDATED_AT = null;

    protected $hidden = ['id'];

    protected $fillable = ['user_id', 'blocked_id'];

    /**
     * The blocker is the caller (see LibraryEntry). A block ends the follows in both directions,
     * through the package so that their events, and the removal of "followed" activities, happen.
     * The caller's memoized block list is reset for the rest of the request.
     */
    protected static function booted(): void
    {
        static::creating(static function (self $block): void {
            if (auth()->check()) {
                $block->user_id = auth()->id();
            }
        });
        // Loaded by id: a block deserialized from the request carries empty relations.
        static::created(static function (self $block): void {
            $blocker = User::findOrFail($block->user_id);
            $blocked = User::findOrFail($block->blocked_id);
            $blocker->unfollow($blocked);
            $blocked->unfollow($blocker);
            auth()->user()?->forgetBlockedUserIds();
        });
        static::deleted(static fn () => auth()->user()?->forgetBlockedUserIds());
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function blocked(): BelongsTo
    {
        return $this->belongsTo(User::class, 'blocked_id');
    }
}
