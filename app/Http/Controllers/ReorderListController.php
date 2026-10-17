<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\GameList;
use App\Models\ListItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Rewrites the order of a list in one go: the body names every item of the list exactly once,
 * and its position in `ids` becomes the item's position.
 */
class ReorderListController
{
    public function __invoke(Request $request, int $list): Response
    {
        abort_unless($request->user()?->tokenCan('library'), 403);
        $ids = $request->validate([
            'ids' => ['present', 'array', 'list'],
            'ids.*' => ['integer:strict', 'distinct'],
        ])['ids'];

        DB::transaction(static function () use ($request, $list, $ids): void {
            // Someone else's list is a 404, as on every other write. The lock serialises concurrent reorders.
            $owned = GameList::whereKey($list)->where('user_id', $request->user()->id)->lockForUpdate()->firstOrFail();
            $current = $owned->items()->pluck('id')->all();
            if (count($ids) !== count($current) || array_diff($ids, $current) !== []) {
                throw ValidationException::withMessages(['ids' => 'List every item of this list exactly once.']);
            }

            foreach ($ids as $position => $id) {
                ListItem::whereKey($id)->update(['position' => $position]);
            }
            $owned->touch();
        });

        return response()->noContent();
    }
}
