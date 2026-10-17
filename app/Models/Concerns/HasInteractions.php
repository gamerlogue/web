<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\Notification;
use App\Models\Reaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Reactions on a model, and the cleanup of everything others did on it.
 */
trait HasInteractions
{
    /**
     * @return MorphMany<Reaction, $this>
     */
    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    /**
     * One row per reaction type, with its `total`: eager-loaded, a page of models costs one query.
     *
     * @return MorphMany<Reaction, $this>
     */
    public function reactionCounts(): MorphMany
    {
        return $this->reactions()
            ->selectRaw('reactable_type, reactable_id, type, COUNT(*) AS total')
            ->groupBy('reactable_type', 'reactable_id', 'type');
    }

    /**
     * Removes the reactions to this model and the notifications about it. Bulk deletes: a
     * reaction has nothing of its own to clean up.
     */
    public function forgetInteractions(): void
    {
        $this->reactions()->delete();
        Notification::forgetSubject($this);
    }
}
