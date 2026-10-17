<?php

declare(strict_types=1);

namespace App\Extensions;

use ApiPlatform\Laravel\Eloquent\Extension\QueryExtensionInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ParameterNotFound;
use App\Enums\Visibility;
use App\Exceptions\ApiDomainException;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\ListItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

/**
 * Scopes every query to what the authenticated user may see. Discovered automatically: API
 * Platform autoconfigures anything implementing QueryExtensionInterface.
 *
 * Writes are always limited to the caller's own resources, so someone else's is a 404.
 */
final class OwnedResourcesExtension implements QueryExtensionInterface
{
    public function apply(Builder $builder, array $uriVariables, Operation $operation, mixed $context = []): Builder
    {
        $reading = request()->isMethod('GET');

        return match ($operation->getClass()) {
            LibraryEntry::class => $reading
                ? $this->libraryEntries($builder, $operation)
                : $builder->where('user_id', auth()->id()),
            User::class => $reading && ($uriVariables !== [] || $this->parameter($operation, 'filter[search]') !== null)
                ? $this->users($builder, $operation)
                // Without a search the collection is the "current user" endpoint: it holds the
                // caller and no one else, so a client that does not know its own id can still fetch itself.
                : $builder->whereKey(auth()->id()),
            GameList::class => $reading
                ? $this->lists($builder, $uriVariables, $operation)
                : $builder->where('user_id', auth()->id()),
            ListItem::class => $reading
                ? $this->listItems($builder, $uriVariables, $operation)
                : $builder->whereHas('list', static fn (Builder $list) => $list->where('user_id', auth()->id())),
            default => $builder,
        };
    }

    /**
     * @param  Builder<LibraryEntry>  $builder
     * @return Builder<LibraryEntry>
     */
    private function libraryEntries(Builder $builder, Operation $operation): Builder
    {
        $ownerId = $this->ownerFilter($operation);
        if ($ownerId !== null) {
            $this->assertProfileVisible(User::findOrFail($ownerId));
        }
        $builder->where('user_id', $ownerId ?? auth()->id())->with('user');

        return match ($this->parameter($operation, 'filter[has_review]')) {
            'true' => $builder->whereNotNull('review')->where('review', '<>', ''),
            'false' => $builder->where(static fn (Builder $query) => $query->whereNull('review')->orWhere('review', '')),
            default => $builder,
        };
    }

    /**
     * Someone else's private list does not exist for the caller (404); every list of a private
     * profile is refused as such (403).
     *
     * @param  Builder<GameList>  $builder
     * @param  array<string, mixed>  $uriVariables
     * @return Builder<GameList>
     */
    private function lists(Builder $builder, array $uriVariables, Operation $operation): Builder
    {
        // The JSON:API document links every list to its owner and items, included or not.
        $builder->withCount('items')->with(['user', 'items']);
        if ($uriVariables !== []) {
            $this->assertProfileVisible(GameList::find($uriVariables['id'])?->user);

            return $this->visibleLists($builder);
        }

        $ownerId = $this->ownerFilter($operation);
        if ($ownerId !== null) {
            $this->assertProfileVisible(User::findOrFail($ownerId));
            $builder->where('visibility', Visibility::Public);
        }
        $builder->where('user_id', $ownerId ?? auth()->id());

        $gameId = $this->parameter($operation, 'filter[contains_game]');
        if ($gameId !== null) {
            $builder->whereHas('items', static fn (Builder $items) => $items->where('game_id', $gameId));
        }

        return $builder;
    }

    /**
     * Items follow the visibility of their list.
     *
     * @param  Builder<ListItem>  $builder
     * @param  array<string, mixed>  $uriVariables
     * @return Builder<ListItem>
     */
    private function listItems(Builder $builder, array $uriVariables, Operation $operation): Builder
    {
        // An included list carries its items_count and its own item linkage.
        $builder->with(['list' => static fn ($list) => $list->withCount('items'), 'list.items']);
        $listId = $uriVariables === [] ? $this->parameter($operation, 'filter[list]') : ListItem::find($uriVariables['id'])?->list_id;
        if ($listId === null) {
            return $builder->whereHas('list', static fn (Builder $list) => $list->where('user_id', auth()->id()));
        }

        $this->assertProfileVisible(GameList::find($listId)?->user);

        return $builder->where('list_id', $listId)->whereHas('list', fn (Builder $list) => $this->visibleLists($list));
    }

    /**
     * Any profile can be read; the serializer hides what a private one does not share.
     *
     * @param  Builder<User>  $builder
     * @return Builder<User>
     */
    private function users(Builder $builder, Operation $operation): Builder
    {
        $search = $this->parameter($operation, 'filter[search]');
        if (! is_string($search)) {
            return $builder;
        }

        // Every word has to appear in the nickname, first or last name, so "mario ros" finds Mario Rossi.
        foreach (preg_split('/\s+/', mb_strtolower(trim($search)), flags: PREG_SPLIT_NO_EMPTY) ?: [] as $word) {
            $pattern = '%' . str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $word) . '%';
            $builder->where(static fn (Builder $query) => $query
                ->whereRaw("LOWER(nickname) LIKE ? ESCAPE '!'", [$pattern])
                ->orWhereRaw("LOWER(first_name) LIKE ? ESCAPE '!'", [$pattern])
                ->orWhereRaw("LOWER(last_name) LIKE ? ESCAPE '!'", [$pattern]));
        }

        return $builder;
    }

    /**
     * @param  Builder<GameList>  $builder
     * @return Builder<GameList>
     */
    private function visibleLists(Builder $builder): Builder
    {
        return $builder->where(static fn (Builder $query) => $query
            ->where('user_id', auth()->id())
            ->orWhere('visibility', Visibility::Public));
    }

    /**
     * A missing owner means a missing resource, which the query itself turns into a 404.
     */
    private function assertProfileVisible(?User $owner): void
    {
        if ($owner !== null && Gate::denies('viewProfile', $owner)) {
            throw ApiDomainException::profilePrivate();
        }
    }

    /**
     * The other user named by filter[user], or null for the caller. current_user=true always means
     * the caller, whatever else is asked.
     */
    private function ownerFilter(Operation $operation): ?string
    {
        $ownerId = request()->boolean('current_user') ? null : $this->parameter($operation, 'filter[user]');

        return $ownerId === auth()->id() ? null : $ownerId;
    }

    private function parameter(Operation $operation, string $key): mixed
    {
        $value = $operation->getParameters()?->get($key)?->getValue();

        return $value instanceof ParameterNotFound ? null : $value;
    }
}
