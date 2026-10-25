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
use App\Http\Requests\ListItemRequest;
use App\Observers\ListItemObserver;
use Database\Factories\ListItemFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $position
 */
#[ObservedBy(ListItemObserver::class)]
#[ApiResource(
    shortName: 'ListItem',
    description: 'A game in a custom list.',
    operations: [
        new GetCollection(uriTemplate: '/list_items', order: ['position' => 'ASC', 'id' => 'ASC']),
        new Get(uriTemplate: '/list_items/{id}'),
        new Post(uriTemplate: '/list_items'),
        new Patch(uriTemplate: '/list_items/{id}'),
        new Delete(uriTemplate: '/list_items/{id}'),
    ],
    rules: ListItemRequest::class
)]
#[ApiProperty(description: 'The list this game belongs to; set on creation only.', property: 'list_id')]
#[ApiProperty(property: 'list', writable: false)]
#[ApiProperty(description: 'The IGDB game, which need not be in the library.', property: 'game_id')]
#[ApiProperty(description: 'Zero-based order in the list; appended at the end when omitted on creation.', property: 'position')]
#[QueryParameter('filter[list]', description: "The list whose games to read; without it, the games of the caller's own lists", constraints: ['integer', 'min:1'])]
class ListItem extends Model
{
    /** @use HasFactory<ListItemFactory> */
    use HasFactory;

    protected $hidden = ['id'];

    protected $fillable = ['list_id', 'game_id', 'position', 'note'];

    protected static function booted(): void
    {
        static::creating(static function (self $item): void {
            if ($item->position === null) {
                $last = self::where('list_id', $item->list_id)->max('position');
                $item->position = $last === null ? 0 : (int) $last + 1;
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['list_id' => 'integer', 'game_id' => 'integer', 'position' => 'integer'];
    }

    /**
     * @return BelongsTo<GameList, $this>
     */
    public function list(): BelongsTo
    {
        return $this->belongsTo(GameList::class, 'list_id');
    }
}
