<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\ApiDomainException;
use App\Models\Comment;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Http\FormRequest;

/**
 * The review, list or comment a new comment or reaction targets, checked for the caller: visible
 * to them, outside any block, and for a library entry, an actual review.
 *
 * @mixin FormRequest
 */
trait ResolvesInteractionTarget
{
    public const array INTERACTION_TYPES = ['library_entry', 'list', 'comment'];

    protected function interactionTarget(string $typeKey, string $idKey): LibraryEntry|GameList|Comment|null
    {
        $class = Relation::getMorphedModel((string) $this->input($typeKey));
        $id = $this->input($idKey);
        if (! in_array($this->input($typeKey), self::INTERACTION_TYPES, true) || ! is_int($id) || $class === null) {
            return null;
        }

        /** @var LibraryEntry|GameList|Comment|null $target */
        $target = $class::find($id);
        if ($target === null) {
            return null;
        }

        /** @var User $viewer */
        $viewer = $this->user();
        $target->ensureVisibleTo($viewer);
        if ($target instanceof LibraryEntry && ! $target->hasReview()) {
            throw new ApiDomainException(422, 'review_required', 'Only a library entry with a review can be liked or commented.');
        }

        return $target;
    }
}
