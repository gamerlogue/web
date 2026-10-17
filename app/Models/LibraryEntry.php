<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Laravel\Eloquent\Filter\BooleanFilter;
use ApiPlatform\Laravel\Eloquent\Filter\DateFilter;
use ApiPlatform\Laravel\Eloquent\Filter\EqualsFilter;
use ApiPlatform\Laravel\Eloquent\Filter\JsonApi\SortFilter;
use ApiPlatform\Laravel\Eloquent\Filter\RangeFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\QueryParameter;
use App\Enums\LibraryEntryCompletionStatus;
use App\Enums\LibraryEntryStatus;
use App\Http\Middleware\LibraryImport;
use App\Http\Requests\LibraryEntryFormRequest;
use App\Observers\LibraryEntryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\TypeInfo\Type\BuiltinType;
use Symfony\Component\TypeInfo\TypeIdentifier;

/**
 * @property int[] $editions_ids
 * @property int[] $platforms_ids
 */
#[ObservedBy(LibraryEntryObserver::class)]
#[ApiResource(
    shortName: 'LibraryEntry',
    description: "A user's entry in their game library, representing their interaction with a specific game.",
    middleware: [LibraryImport::class],
    rules: LibraryEntryFormRequest::class
)]
#[ApiProperty(description: 'Whether the review reveals plot details.', property: 'review_spoiler')]
#[ApiProperty(description: 'When the review text last changed, null if there never was one.', property: 'review_updated_at', writable: false)]
#[ApiProperty(description: 'The unique identifier of the game associated with this library entry.', property: 'game_id')]
#[ApiProperty(description: 'The unique identifier of the user who owns this library entry.', property: 'user_id')]
#[ApiProperty(description: 'The user who owns this library entry, always the authenticated user.', writable: false, property: 'user')]
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
#[QueryParameter('filter[user]', description: "Read another user's library instead of the caller's, subject to their profile visibility", constraints: ['uuid'])]
#[QueryParameter('filter[has_review]', description: 'Filter library entries by whether they have a non-empty review', constraints: ['in:true,false'])]
#[QueryParameter('filter[game_id]', filter: EqualsFilter::class, property: 'game_id', description: 'Filter library entries by the associated game ID')]
#[QueryParameter('filter[status]', filter: EqualsFilter::class, property: 'status', description: 'Filter library entries by play status, one of the values of the status attribute', constraints: [new Enum(LibraryEntryStatus::class)])]
#[QueryParameter('filter[completion_status]', filter: EqualsFilter::class, property: 'completion_status', description: 'Filter library entries by completion status, one of the values of the completion_status attribute', constraints: [new Enum(LibraryEntryCompletionStatus::class)])]
#[QueryParameter('filter[owned]', filter: BooleanFilter::class, property: 'owned', description: 'Filter library entries by whether the user owns the game')]
#[QueryParameter('filter[start_date]', filter: DateFilter::class, property: 'start_date', description: 'Filter library entries by start date, with the eq, gt, lt, gte and lte operators')]
#[QueryParameter('filter[end_date]', filter: DateFilter::class, property: 'end_date', description: 'Filter library entries by end date, with the eq, gt, lt, gte and lte operators')]
#[QueryParameter('filter[rating]', filter: RangeFilter::class, property: 'rating', description: 'Filter library entries by rating, with the gt, lt, gte and lte operators', constraints: ['array:gt,lt,gte,lte'])]
#[QueryParameter('filter[played_time]', filter: RangeFilter::class, property: 'played_time', description: 'Filter library entries by played time, with the gt, lt, gte and lte operators', constraints: ['array:gt,lt,gte,lte'])]
#[QueryParameter(
    'sort',
    filter: SortFilter::class,
    description: 'Comma-separated fields to sort by, descending when prefixed with "-" (e.g. "-rating,start_date")',
    properties: ['start_date', 'end_date', 'rating', 'played_time', 'created_at', 'updated_at', 'review_updated_at']
)]
class LibraryEntry extends Model
{
    private const string STATS_VERSION_KEY = 'profile_stats_version:';

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
        'review_spoiler',
    ];

    /** @var array<string, mixed> */
    protected $attributes = ['review_spoiler' => false];

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

        // Null and empty both mean "no review", so moving between them is not an edit.
        static::saving(static function (self $entry): void {
            if ((string) $entry->review !== (string) $entry->getOriginal('review')) {
                $entry->review_updated_at = now();
            }
        });

        // Any write changes the owner's statistics; bumping the version orphans every cached year.
        // Bulk queries skip model events, so their changes show once the cache expires (a day).
        $invalidateStats = static fn (self $entry) => Cache::forever(self::STATS_VERSION_KEY . $entry->user_id, (string) Str::uuid());
        static::saved($invalidateStats);
        static::deleted($invalidateStats);
    }

    public static function statsVersion(string $userId): string
    {
        return Cache::get(self::STATS_VERSION_KEY . $userId, 'initial');
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
            'review_spoiler' => 'boolean',
            'review_updated_at' => 'datetime',
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

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
