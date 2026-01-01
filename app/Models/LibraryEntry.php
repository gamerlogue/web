<?php

namespace App\Models;

use ApiPlatform\Laravel\Eloquent\Filter\EqualsFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\QueryParameter;
use App\Enums\LibraryEntryCompletionStatus;
use App\Enums\LibraryEntryStatus;
use App\Filter\CurrentUserFilter;
use App\Http\Requests\LibraryEntryFormRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ApiResource(
    shortName: 'LibraryEntry',
    description: "A user's entry in their game library, representing their interaction with a specific game.",
    rules: LibraryEntryFormRequest::class
)]
#[ApiProperty(description: 'The unique identifier of the game associated with this library entry.', property: 'game_id')]
#[ApiProperty(description: 'The unique identifier of the user who owns this library entry.', property: 'user_id')]
#[QueryParameter('current_user', filter: CurrentUserFilter::class, description: 'Filter library entries by the current authenticated user')]
#[QueryParameter('filter[user_id]', filter: EqualsFilter::class, property: 'user_id', description: 'Filter library entries by the associated user ID')]
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
        'edition_id',
        'platforms_ids',
        'start_date',
        'end_date',
        'played_time',
        'rating',
        'rating_details',
        'review',
    ];

    protected $casts = [
        'game_id' => 'int',
        'owned' => 'boolean',
        'platforms_ids' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'played_time' => 'int',
        'rating' => 'float',
        'rating_details' => 'array',
        'status' => LibraryEntryStatus::class,
        'completion_status' => LibraryEntryCompletionStatus::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
