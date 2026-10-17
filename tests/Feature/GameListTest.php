<?php

declare(strict_types=1);

use App\Enums\Visibility;
use App\Models\GameList;
use App\Models\ListItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * @param  array<string, mixed>  $attributes
 * @return array<string, mixed>
 */
function resourceDocument(string $type, array $attributes): array
{
    return ['data' => ['type' => $type, 'attributes' => $attributes]];
}

/**
 * @return list<int>
 */
function listIds(User $viewer, string $query): array
{
    return collect(actingAsNative($viewer)
        ->getJson("/api/lists?$query", jsonApiHeaders())
        ->assertOk()
        ->json('data'))->pluck('id')->map(static fn (string $id): int => (int) $id)->all();
}

test('the owner manages a list and its games', function () {
    $owner = User::factory()->create();

    $listId = actingAsNative($owner)
        ->postJson('/api/lists', resourceDocument('List', ['name' => 'Best of 2026', 'is_ranked' => true]), jsonApiHeaders())
        ->assertCreated()
        ->assertJsonPath('data.attributes.visibility', 'public')
        ->assertJsonPath('data.attributes.items_count', 0)
        ->json('data.id');
    expect(GameList::findOrFail($listId)->user_id)->toBe($owner->id);

    $first = actingAsNative($owner)
        ->postJson('/api/list_items', resourceDocument('ListItem', ['list_id' => (int) $listId, 'game_id' => 42, 'note' => 'Top']), jsonApiHeaders())
        ->assertCreated()
        ->assertJsonPath('data.attributes.position', 0)
        ->json('data.id');
    actingAsNative($owner)
        ->postJson('/api/list_items', resourceDocument('ListItem', ['list_id' => (int) $listId, 'game_id' => 7]), jsonApiHeaders())
        ->assertCreated()
        ->assertJsonPath('data.attributes.position', 1);

    actingAsNative($owner)
        ->getJson("/api/lists/{$listId}?include=items,user", jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.attributes.items_count', 2)
        ->assertJsonPath('data.attributes.is_ranked', true)
        ->assertJsonCount(3, 'included');

    actingAsNative($owner)
        ->patchJson("/api/list_items/{$first}", resourceDocument('ListItem', ['note' => null]), jsonApiHeaders())
        ->assertOk();
    actingAsNative($owner)
        ->patchJson("/api/lists/{$listId}", resourceDocument('List', ['name' => 'Renamed', 'visibility' => 'private']), jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.attributes.visibility', 'private');

    actingAsNative($owner)->deleteJson("/api/list_items/{$first}", [], jsonApiHeaders())->assertNoContent();
    actingAsNative($owner)->deleteJson("/api/lists/{$listId}", [], jsonApiHeaders())->assertNoContent();
    expect(ListItem::count())->toBe(0);
});

test('list and item input is validated', function (string $uri, array $attributes) {
    $owner = User::factory()->create();
    $list = GameList::factory()->for($owner)->create();
    ListItem::factory()->for($list, 'list')->create(['game_id' => 5]);
    $foreign = GameList::factory()->create();
    $attributes = array_map(static fn ($value) => match ($value) {
        'OWN' => $list->id,
        'FOREIGN' => $foreign->id,
        default => $value,
    }, $attributes);

    actingAsNative($owner)->postJson($uri, resourceDocument($uri === '/api/lists' ? 'List' : 'ListItem', $attributes), jsonApiHeaders())
        ->assertUnprocessable();
})->with([
    'list without name' => ['/api/lists', ['description' => 'x']],
    'list name too long' => ['/api/lists', ['name' => str_repeat('a', 101)]],
    'unknown visibility' => ['/api/lists', ['name' => 'x', 'visibility' => 'friends']],
    'item without game' => ['/api/list_items', ['list_id' => 'OWN']],
    'game not positive' => ['/api/list_items', ['list_id' => 'OWN', 'game_id' => 0]],
    'game already listed' => ['/api/list_items', ['list_id' => 'OWN', 'game_id' => 5]],
    'someone elses list' => ['/api/list_items', ['list_id' => 'FOREIGN', 'game_id' => 1]],
    'negative position' => ['/api/list_items', ['list_id' => 'OWN', 'game_id' => 1, 'position' => -1]],
]);

test('an items list and game cannot be changed', function () {
    $item = ListItem::factory()->create();

    actingAsNative($item->list->user)
        ->patchJson("/api/list_items/{$item->id}", resourceDocument('ListItem', ['game_id' => 99]), jsonApiHeaders())
        ->assertUnprocessable();
});

test('someone elses lists and items cannot be written', function () {
    $item = ListItem::factory()->create();
    $intruder = User::factory()->create();

    actingAsNative($intruder)->patchJson("/api/lists/{$item->list_id}", resourceDocument('List', ['name' => 'x']), jsonApiHeaders())->assertNotFound();
    actingAsNative($intruder)->deleteJson("/api/lists/{$item->list_id}", [], jsonApiHeaders())->assertNotFound();
    actingAsNative($intruder)->patchJson("/api/list_items/{$item->id}", resourceDocument('ListItem', ['note' => 'x']), jsonApiHeaders())->assertNotFound();
    actingAsNative($intruder)->deleteJson("/api/list_items/{$item->id}", [], jsonApiHeaders())->assertNotFound();
    actingAsNative($intruder)->postJson("/api/lists/{$item->list_id}/reorder", ['ids' => [$item->id]])->assertNotFound();

    expect($item->fresh())->not->toBeNull();
});

test('lists are filtered by owner and contained game', function () {
    $me = User::factory()->create();
    $other = User::factory()->create();
    $mine = GameList::factory()->for($me)->create();
    $minePrivate = GameList::factory()->for($me)->private()->create();
    $theirs = GameList::factory()->for($other)->create();
    GameList::factory()->for($other)->private()->create();
    ListItem::factory()->for($minePrivate, 'list')->create(['game_id' => 10]);
    ListItem::factory()->for($theirs, 'list')->create(['game_id' => 10]);

    expect(listIds($me, ''))->toEqualCanonicalizing([$mine->id, $minePrivate->id])
        ->and(listIds($me, "filter[user]={$other->id}"))->toBe([$theirs->id])
        ->and(listIds($me, 'filter[contains_game]=10'))->toBe([$minePrivate->id])
        ->and(listIds($me, "filter[user]={$other->id}&filter[contains_game]=10"))->toBe([$theirs->id])
        ->and(listIds($me, "current_user=true&filter[user]={$other->id}"))->toEqualCanonicalizing([$mine->id, $minePrivate->id]);
});

test('private lists and the lists of private profiles stay hidden', function () {
    $viewer = User::factory()->create();
    $owner = User::factory()->create();
    $privateList = GameList::factory()->for($owner)->private()->create();
    $privateItem = ListItem::factory()->for($privateList, 'list')->create();
    $hiddenOwner = User::factory()->create(['visibility' => Visibility::Private]);
    $hiddenList = GameList::factory()->for($hiddenOwner)->create();
    $hiddenItem = ListItem::factory()->for($hiddenList, 'list')->create();

    actingAsNative($viewer)->getJson("/api/lists/{$privateList->id}", jsonApiHeaders())->assertNotFound();
    actingAsNative($viewer)->getJson("/api/list_items/{$privateItem->id}", jsonApiHeaders())->assertNotFound();
    actingAsNative($viewer)->getJson("/api/list_items?filter[list]={$privateList->id}", jsonApiHeaders())
        ->assertOk()->assertJsonCount(0, 'data');

    foreach ([
        "/api/lists/{$hiddenList->id}",
        "/api/lists?filter[user]={$hiddenOwner->id}",
        "/api/list_items/{$hiddenItem->id}",
        "/api/list_items?filter[list]={$hiddenList->id}",
    ] as $uri) {
        actingAsNative($viewer)->getJson($uri, jsonApiHeaders())
            ->assertForbidden()
            ->assertJsonPath('errors.0.code', 'profile_private');
    }

    actingAsNative($hiddenOwner)->getJson("/api/lists/{$hiddenList->id}", jsonApiHeaders())->assertOk();
    actingAsNative($owner)->getJson("/api/lists/{$privateList->id}", jsonApiHeaders())->assertOk();
});

test('a public list of a public profile is readable with its games in order', function () {
    $list = GameList::factory()->create();
    $second = ListItem::factory()->for($list, 'list')->create(['position' => 1]);
    $first = ListItem::factory()->for($list, 'list')->create(['position' => 0]);

    $ids = collect(actingAsNative(User::factory()->create())
        ->getJson("/api/list_items?filter[list]={$list->id}", jsonApiHeaders())
        ->assertOk()
        ->json('data'))->pluck('id')->all();

    expect($ids)->toBe([(string) $first->id, (string) $second->id]);
});

test('the list collection does not query once per list', function () {
    $owner = User::factory()->create();
    GameList::factory()->for($owner)->count(5)->hasItems(3)->create();

    DB::enableQueryLog();
    actingAsNative($owner)->getJson('/api/lists?include=items,user', jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.4.attributes.items_count', 3);
    expect(count(DB::getQueryLog()))->toBeLessThan(10);

    DB::flushQueryLog();
    actingAsNative($owner)->getJson('/api/list_items?include=list', jsonApiHeaders())
        ->assertOk()
        ->assertJsonCount(15, 'data');
    expect(count(DB::getQueryLog()))->toBeLessThan(10);
});

test('the owner reorders a list in one request', function () {
    $list = GameList::factory()->create();
    [$a, $b, $c] = ListItem::factory()->for($list, 'list')->count(3)->sequence(['position' => 0], ['position' => 1], ['position' => 2])->create();

    actingAsNative($list->user)->postJson("/api/lists/{$list->id}/reorder", ['ids' => [$c->id, $a->id, $b->id]])
        ->assertNoContent();

    expect($list->items()->pluck('id')->all())->toBe([$c->id, $a->id, $b->id]);
});

test('a reorder naming the wrong items changes nothing', function (Closure $ids) {
    $list = GameList::factory()->create();
    $items = ListItem::factory()->for($list, 'list')->count(2)->sequence(['position' => 0], ['position' => 1])->create();
    $foreign = ListItem::factory()->create();

    actingAsNative($list->user)->postJson("/api/lists/{$list->id}/reorder", ['ids' => $ids($items, $foreign)])
        ->assertUnprocessable();

    expect($list->items()->pluck('id')->all())->toBe($items->pluck('id')->all());
})->with([
    'missing one' => [fn ($items) => [$items[1]->id]],
    'duplicated' => [fn ($items) => [$items[1]->id, $items[1]->id]],
    'foreign item' => [fn ($items, $foreign) => [$items[1]->id, $foreign->id]],
    'not integers' => [fn ($items) => [(string) $items[1]->id, (string) $items[0]->id]],
]);
