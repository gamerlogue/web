<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\Notification;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Reactions on a model, and the cleanup of everything others did on it.
 */
trait HasInteractions
{
    /**
     * Refuses a viewer who may not see this model, with the HTTP error the API answers.
     */
    abstract public function ensureVisibleTo(User $viewer): void;

    /**
     * ensureVisibleTo() as a boolean, for choosing whom to notify.
     */
    public function isVisibleTo(User $viewer): bool
    {
        try {
            $this->ensureVisibleTo($viewer);
        } catch (HttpException) {
            return false;
        }

        return true;
    }

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
