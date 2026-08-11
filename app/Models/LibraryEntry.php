<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Laravel\Eloquent\Filter\EqualsFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\QueryParameter;
use App\Enums\LibraryEntryCompletionStatus;
use App\Enums\LibraryEntryStatus;
use App\Http\Requests\LibraryEntryFormRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\TypeInfo\Type\BuiltinType;
use Symfony\Component\TypeInfo\TypeIdentifier;

/**
 * @property array $editions_ids
 * @property array $platforms_ids
 */
#[ApiResource(
    shortName: 'LibraryEntry',
    description: "A user's entry in their game library, representing their interaction with a specific game.",
    rules: LibraryEntryFormRequest::class
)]
#[ApiProperty(description: 'The unique identifier of the game associated with this library entry.', property: 'game_id')]
#[ApiProperty(description: 'The unique identifier of the user who owns this library entry.', property: 'user_id')]
#[ApiProperty(
    description: 'The unique identifiers of the game editions associated with this library entry.',
    property: 'editions_ids',
    nativeType: new BuiltinType(TypeIdentifier::ARRAY)
)]
#[ApiProperty(
    description: 'The unique identifiers of the platforms associated with this library entry.',
    property: 'platforms_ids',
    nativeType: new BuiltinType(TypeIdentifier::ARRAY)
)]
#[QueryParameter('filter[game_id]', filter: EqualsFilter::class, property: 'game_id', description: 'Filter library entries by the associated game ID')]
class LibraryEntry extends Model
{
    protected $hidden = ['id'];

    protected $fillable = [
        'user_id',
        'game_id',
        'status',
        'completion_status',
        'owned',
        'editions_ids',
        'platforms_ids',
        'start_date',
        'end_date',
        'played_time',
        'rating',
        'rating_details',
        'review',
    ];

    /**
     * The owner cannot be taken from the request body: API Platform persists the deserialized
     * payload, not the validated data, so a FormRequest can reject a foreign owner but never
     * replace it. Assigning it here covers every write that happens for an authenticated user,
     * while leaving factories, seeders and console commands free to set it explicitly.
     */
    protected static function booted(): void
    {
        static::creating(static function (self $entry): void {
            if (auth()->check()) {
                $entry->user_id = auth()->id();
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'game_id' => 'int',
            'owned' => 'boolean',
            'editions_ids' => 'array',
            'platforms_ids' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
            'played_time' => 'int',
            'rating' => 'float',
            'rating_details' => 'array',
            'status' => LibraryEntryStatus::class,
            'completion_status' => LibraryEntryCompletionStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
