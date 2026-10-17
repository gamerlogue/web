<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Enums\ReportReason;
use App\Http\Requests\ReportRequest;
use Illuminate\Database\Eloquent\Model;

/**
 * A user's report of a profile or of content, stored for moderation. There is no moderation
 * interface yet: reports are only collected.
 */
#[ApiResource(
    description: 'A report of a user or of content, for moderators to review.',
    operations: [
        new Post(middleware: ['throttle:10,1']),
        // Only so the created report has an IRI; it reads back the caller's own reports.
        new Get,
    ],
    rules: ReportRequest::class
)]
#[ApiProperty(description: 'What is reported: user, library_entry or list.', property: 'reportable_type')]
#[ApiProperty(description: 'The id of the reported user or content.', property: 'reportable_id')]
#[ApiProperty(property: 'user_id', writable: false)]
class Report extends Model
{
    /**
     * Reportable types and the model each one names.
     *
     * @var array<string, class-string<Model>>
     */
    public const array REPORTABLE_TYPES = [
        'user' => User::class,
        'library_entry' => LibraryEntry::class,
        'list' => GameList::class,
    ];

    protected $hidden = ['id'];

    protected $fillable = ['reportable_type', 'reportable_id', 'reason', 'note'];

    /**
     * The reporter is the caller, never taken from the payload; see LibraryEntry.
     */
    protected static function booted(): void
    {
        static::creating(static function (self $report): void {
            if (auth()->check()) {
                $report->user_id = auth()->id();
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['reportable_id' => 'string', 'reason' => ReportReason::class];
    }
}
