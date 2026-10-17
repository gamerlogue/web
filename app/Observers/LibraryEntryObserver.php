<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\LibraryEntryStatus;
use App\Models\Activity;
use App\Models\LibraryEntry;
use BackedEnum;

/**
 * Turns library writes into activities, or into the single activity of an import.
 */
class LibraryEntryObserver
{
    public function created(LibraryEntry $entry): void
    {
        if (Activity::importing()) {
            Activity::recordImported($entry->user_id);

            return;
        }

        Activity::record($entry->user_id, 'library_added', $entry, ['game_id' => $entry->game_id, 'status' => $entry->status->value]);
        $this->recordFacts($entry, true);
    }

    /**
     * Likes and comments belong to the review: clearing it clears them.
     */
    public function updated(LibraryEntry $entry): void
    {
        if ($entry->wasChanged('review') && ! $entry->hasReview()) {
            $entry->forgetCommunity();
        }
        if (Activity::importing()) {
            return;
        }

        if ($entry->wasChanged('status')) {
            $old = $entry->getOriginal('status');
            Activity::record($entry->user_id, 'status_changed', $entry, [
                'game_id' => $entry->game_id,
                'old' => $old instanceof BackedEnum ? $old->value : $old,
                'new' => $entry->status->value,
            ]);
        }
        $this->recordFacts($entry, false);
    }

    public function deleted(LibraryEntry $entry): void
    {
        Activity::forget($entry);
        $entry->forgetCommunity();
    }

    /**
     * Completion, rating and review: on creation whatever is set, on update whatever changed.
     */
    private function recordFacts(LibraryEntry $entry, bool $created): void
    {
        $payload = ['game_id' => $entry->game_id];
        $changed = static fn (string $attribute): bool => $created || $entry->wasChanged($attribute);

        if ($changed('status') && $entry->status === LibraryEntryStatus::Completed) {
            Activity::record($entry->user_id, 'completed', $entry, $payload + ['completion_status' => $entry->completion_status?->value]);
        }
        if ($changed('rating') && $entry->rating !== null) {
            Activity::record($entry->user_id, 'rated', $entry, $payload + ['rating' => $entry->rating]);
        }
        if ($changed('review') && (string) $entry->review !== '') {
            Activity::record($entry->user_id, 'reviewed', $entry, $payload + ['review_spoiler' => $entry->review_spoiler]);
        }
    }
}
