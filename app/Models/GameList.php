<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\QueryParameter;
use App\Enums\Visibility;
use App\Http\Requests\GameListRequest;
use App\Observers\GameListObserver;
use Database\Factories\GameListFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(GameListObserver::class)]
#[ApiResource(
    shortName: 'List',
    description: 'A custom, optionally ranked list of games curated by a user.',
    operations: [
        new GetCollection(uriTemplate: '/lists', order: ['id' => 'ASC']),
        new Get(uriTemplate: '/lists/{id}'),
        new Post(uriTemplate: '/lists'),
        new Patch(uriTemplate: '/lists/{id}'),
        new Delete(uriTemplate: '/lists/{id}'),
    ],
    rules: GameListRequest::class
)]
#[ApiProperty(description: 'The user who owns this list, always the authenticated user on creation.', property: 'user', writable: false)]
#[ApiProperty(property: 'user_id', writable: false)]
#[ApiProperty(description: 'The games of the list, ordered by position.', property: 'items', writable: false)]
#[ApiProperty(description: 'How many games the list holds.', property: 'items_count', writable: false)]
#[QueryParameter('filter[user]', description: "Read another user's public lists instead of the caller's", constraints: ['uuid'])]
#[QueryParameter('filter[contains_game]', description: 'Only lists holding this IGDB game', constraints: ['integer', 'min:1'])]
class GameList extends Model
{
    /** @use HasFactory<GameListFactory> */
    use HasFactory;

    protected $hidden = ['id'];

    protected $fillable = ['user_id', 'name', 'description', 'visibility', 'is_ranked'];

    /** @var array<string, mixed> */
    protected $attributes = ['visibility' => 'public', 'is_ranked' => false];

    /**
     * Same reasoning as LibraryEntry: the owner is assigned here, never taken from the payload.
     */
    protected static function booted(): void
    {
        static::creating(static function (self $list): void {
            if (auth()->check()) {
                $list->user_id = auth()->id();
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['is_ranked' => 'boolean', 'visibility' => Visibility::class];
    }

    /**
     * Counted by the query (withCount) on reads; a write response counts on its own.
     *
     * @return Attribute<int, never>
     */
    protected function itemsCount(): Attribute
    {
        return Attribute::get(fn (?int $value): int => $value ?? $this->items()->count());
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<ListItem, $this>
     */
    public function items(): HasMany
    {
        // chaperone() hands every item its list, which the JSON:API linkage of an included item reads.
        return $this->hasMany(ListItem::class, 'list_id')->orderBy('position')->orderBy('id')->chaperone('list');
    }
}
