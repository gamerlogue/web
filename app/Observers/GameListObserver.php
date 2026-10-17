<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Activity;
use App\Models\GameList;

class GameListObserver
{
    public function created(GameList $list): void
    {
        Activity::record($list->user_id, 'list_created', $list, ['name' => $list->name]);
    }

    /**
     * Also takes list_item_added, whose subject is the list as well.
     */
    public function deleted(GameList $list): void
    {
        Activity::forget($list);
        $list->forgetCommunity();
    }
}
