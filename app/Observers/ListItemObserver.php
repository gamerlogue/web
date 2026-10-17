<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Activity;
use App\Models\ListItem;

class ListItemObserver
{
    /**
     * The subject is the list, so a burst of additions folds into one activity listing every game
     * added since it started.
     *
     * ponytail: three queries per added game, fine for hand-built lists; batch it if lists ever get
     * filled in bulk.
     */
    public function created(ListItem $item): void
    {
        $list = $item->list;
        $activity = Activity::record($list->user_id, 'list_item_added', $list, ['name' => $list->name]);
        $activity->update(['payload' => ['game_ids' => $list->items()->where('created_at', '>=', $activity->created_at)->pluck('game_id')->all()] + $activity->payload]);
    }
}
