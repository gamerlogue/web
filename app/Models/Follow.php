<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Laravel\Eloquent\Filter\EqualsFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\QueryParameter;
use App\Http\Requests\FollowRequest;
use Overtrue\LaravelFollow\Followable;

/**
 * The caller following a user, as a resource. The package's model with an API: its Followed and
 * Unfollowed events still fire on create and delete.
 */
#[ApiResource(
    description: 'The caller following another user.',
    operations: [
        new GetCollection,
        new Get,
        new Post,
        new Delete,
    ],
    rules: FollowRequest::class
)]
#[ApiProperty(description: 'The followed user.', property: 'followable_id')]
#[ApiProperty(description: 'The followed user.', property: 'followable', writable: false)]
#[ApiProperty(description: 'The follower, always the caller.', property: 'user_id', writable: false)]
#[ApiProperty(property: 'user', readable: false, writable: false)]
#[ApiProperty(property: 'follower', readable: false, writable: false)]
#[QueryParameter('filter[followable_id]', filter: EqualsFilter::class, property: 'followable_id', description: 'Whether the caller follows this user', constraints: ['uuid'])]
class Follow extends Followable
{
    /**
     * The package sets its table in the constructor, which API Platform skips when it reads the
     * columns (newInstanceWithoutConstructor).
     */
    protected $table = 'followables';

    protected $hidden = ['id', 'followable_type', 'accepted_at'];

    protected $fillable = ['followable_id'];

    /**
     * Only users are followed, and nobody approves a follow. The package's own saving hook sets
     * user_id to the caller.
     */
    protected static function booted(): void
    {
        static::creating(static function (self $follow): void {
            $follow->followable_type = (new User)->getMorphClass();
            $follow->accepted_at = now()->toDateTimeString();
        });
    }
}
