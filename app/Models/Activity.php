<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Laravel\Eloquent\Filter\JsonApi\SortFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\QueryParameter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Context;
use Symfony\Component\TypeInfo\Type\BuiltinType;
use Symfony\Component\TypeInfo\TypeIdentifier;

/**
 * Something a user did, as shown on their profile and in their followers' feed. Written by model
 * observers, never by the API; filtered for privacy and blocks when read.
 */
#[ApiResource(
    description: 'Something a user did, for profiles and feeds.',
    operations: [
        new GetCollection(order: ['created_at' => 'DESC', 'id' => 'DESC']),
        new Get,
    ],
)]
#[ApiProperty(description: 'What happened: library_added, status_changed, completed, rated, reviewed, list_created, list_item_added, followed, library_imported.', property: 'verb')]
#[ApiProperty(description: 'What the activity renders from, without fetching the subject.', property: 'payload', nativeType: new BuiltinType(TypeIdentifier::ARRAY))]
#[ApiProperty(description: 'The kind of subject: library_entry, list or user.', property: 'subject_type')]
#[QueryParameter('filter[user]', description: "A user's activities instead of the caller's, subject to their visibility", constraints: ['uuid'])]
#[QueryParameter('filter[feed]', description: 'The activities of the users the caller follows', constraints: ['in:true,false'])]
#[QueryParameter('sort', filter: SortFilter::class, description: 'Only "-created_at", the default', properties: ['created_at'])]
class Activity extends Model
{
    /** Repeating a verb on the same subject within this window updates the activity in place. */
    public const int GROUPING_MINUTES = 30;

    /** The Context key holding the batch id of a library import. */
    public const string IMPORT_CONTEXT = 'library_import';

    protected $hidden = ['id', 'subject_class'];

    protected $fillable = ['user_id', 'verb', 'subject_class', 'subject_id', 'payload'];

    /**
     * Records a verb, or folds it into the same verb on the same subject from the last
     * GROUPING_MINUTES. The first `old` value survives the fold, so a burst of status changes still
     * reads "from the status it had, to the one it has".
     *
     * @param  array<string, mixed>  $payload
     */
    public static function record(string $userId, string $verb, Model $subject, array $payload): self
    {
        $recent = self::where('user_id', $userId)
            ->where('verb', $verb)
            ->whereMorphedTo('subject', $subject)
            ->where('created_at', '>=', now()->subMinutes(self::GROUPING_MINUTES))
            ->latest('id')
            ->first();

        if ($recent === null) {
            return self::create(['user_id' => $userId, 'verb' => $verb, 'subject_class' => $subject->getMorphClass(), 'subject_id' => $subject->getKey(), 'payload' => $payload]);
        }

        $recent->payload = array_key_exists('old', $recent->payload) ? ['old' => $recent->payload['old']] + $payload : $payload;
        $recent->touch();

        return $recent;
    }

    /**
     * Whether writes are part of a library import, which records one library_imported activity
     * instead of one per entry.
     */
    public static function importing(): bool
    {
        return Context::has(self::IMPORT_CONTEXT);
    }

    /**
     * Counts one more entry into the library_imported activity of the current import batch.
     */
    public static function recordImported(string $userId): void
    {
        $batch = Context::get(self::IMPORT_CONTEXT);
        $activity = self::where('user_id', $userId)->where('verb', 'library_imported')->where('payload->batch', $batch)->first();
        if ($activity === null) {
            self::create(['user_id' => $userId, 'verb' => 'library_imported', 'subject_class' => User::class, 'subject_id' => $userId, 'payload' => ['batch' => $batch, 'count' => 1]]);

            return;
        }

        $payload = $activity->payload;
        $payload['count']++;
        $activity->update(['payload' => $payload]);
    }

    /**
     * Deleting a subject takes its activities with it.
     */
    public static function forget(Model $subject): void
    {
        self::whereMorphedTo('subject', $subject)->delete();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['payload' => 'array'];
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
    public function subject(): MorphTo
    {
        return $this->morphTo('subject', 'subject_class');
    }

    /**
     * The morph alias of the subject, `user` for users (see the migration).
     *
     * @return Attribute<string, never>
     */
    protected function subjectType(): Attribute
    {
        return Attribute::get(fn (): string => $this->subject_class === User::class ? 'user' : $this->subject_class);
    }
}
