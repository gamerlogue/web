<?php

declare(strict_types=1);

namespace App\Extensions;

use ApiPlatform\Laravel\Eloquent\Extension\QueryExtensionInterface;
use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ParameterNotFound;
use App\Enums\Visibility;
use App\Exceptions\ApiDomainException;
use App\Models\Activity;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\ListItem;
use App\Models\Notification;
use App\Models\Reaction;
use App\Models\Report;
use App\Models\User;
use App\Models\UserBlock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;

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
            User::class => $reading
                ? $this->users($builder->withSocialContext(), $uriVariables, $operation)
                : $builder->whereKey(auth()->id()),
            GameList::class => $reading
                ? $this->lists($builder, $uriVariables, $operation)
                : $builder->where('user_id', auth()->id()),
            ListItem::class => $reading
                ? $this->listItems($builder, $uriVariables, $operation)
                : $builder->whereHas('list', static fn (Builder $list) => $list->where('user_id', auth()->id())),
            Report::class, Follow::class, UserBlock::class, Reaction::class => $builder->where('user_id', auth()->id()),
            Notification::class => $this->notifications($builder, $operation),
            Comment::class => match (request()->method()) {
                'GET' => $this->comments($builder, $uriVariables, $operation),
                // CommentRequest authorizes deletions, open to the thread's owner too.
                'DELETE' => $builder,
                default => $builder->where('user_id', auth()->id()),
            },
            Activity::class => $this->activities($builder, $operation),
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
        $builder->where('user_id', $ownerId ?? auth()->id())->with(['user' => $this->socialContext(...)])->withInteractionCounts();

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
        $builder->withCount('items')->with(['user' => $this->socialContext(...), 'items'])->withInteractionCounts();
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
        $builder->with(['list' => static fn ($list) => $list->withCount('items')->withInteractionCounts(), 'list.items']);
        $listId = $uriVariables === [] ? $this->parameter($operation, 'filter[list]') : ListItem::find($uriVariables['id'])?->list_id;
        if ($listId === null) {
            return $builder->whereHas('list', static fn (Builder $list) => $list->where('user_id', auth()->id()));
        }

        $this->assertProfileVisible(GameList::find($listId)?->user);

        return $builder->where('list_id', $listId)->whereHas('list', fn (Builder $list) => $this->visibleLists($list));
    }

    /**
     * Any profile can be read, except across a block; the serializer hides what a private one does
     * not share.
     *
     * @param  Builder<User>  $builder
     * @param  array<string, mixed>  $uriVariables
     * @return Builder<User>
     */
    private function users(Builder $builder, array $uriVariables, Operation $operation): Builder
    {
        /** @var User $viewer */
        $viewer = auth()->user();
        $template = $operation instanceof HttpOperation ? $operation->getUriTemplate() : null;

        if ($template === '/users/{id}/followers' || $template === '/users/{id}/following') {
            $owner = User::findOrFail($uriVariables['id']);
            $this->assertProfileVisible($owner);
            $relation = $template === '/users/{id}/followers' ? $owner->followers() : $owner->followings();

            return $builder->whereIn('users.id', $relation->getQuery()->select($template === '/users/{id}/followers' ? 'followables.user_id' : 'followable_id'))
                ->whereNotIn('users.id', $viewer->blockedUserIds());
        }
        if ($uriVariables !== []) {
            $user = User::find($uriVariables['id']);
            if ($user !== null && $viewer->isBlockedWith($user)) {
                throw ApiDomainException::userBlocked();
            }

            return $builder;
        }

        $search = $this->parameter($operation, 'filter[search]');
        if (! is_string($search)) {
            // Without a search the collection is the "current user" endpoint: it holds the caller
            // and no one else, so a client that does not know its own id can still fetch itself.
            return $builder->whereKey($viewer->id);
        }

        $builder->whereNotIn('users.id', $viewer->blockedUserIds());

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
     * A profile's activities: the caller's own by default, another user's with filter[user], or
     * those of everyone the caller follows with filter[feed]=true. Activities of private profiles
     * and across blocks are recorded but never read by others, and neither is anything about
     * someone else's private list.
     *
     * @param  Builder<Activity>  $builder
     * @return Builder<Activity>
     */
    private function activities(Builder $builder, Operation $operation): Builder
    {
        /** @var User $viewer */
        $viewer = auth()->user();
        $builder->with([
            'user' => $this->socialContext(...),
            // Each kind of subject with what its own document links or counts.
            'subject' => fn (MorphTo $subject) => $subject
                ->constrain([
                    User::class => static fn (Builder $user) => $user->withSocialContext(),
                    GameList::class => static fn (Builder $list) => $list->withCount('items')->withInteractionCounts(),
                    LibraryEntry::class => static fn (Builder $entry) => $entry->withInteractionCounts(),
                ])
                ->morphWith([
                    LibraryEntry::class => ['user' => $this->socialContext(...)],
                    GameList::class => ['user' => $this->socialContext(...), 'items'],
                ]),
        ]);

        if ($this->parameter($operation, 'filter[feed]') === 'true') {
            $builder->whereIn('user_id', $viewer->followings()->select('followable_id'))
                ->whereNotIn('user_id', $viewer->blockedUserIds())
                ->whereIn('user_id', User::where('visibility', Visibility::Public)->select('id'));
        } else {
            $ownerId = $this->parameter($operation, 'filter[user]');
            if ($ownerId !== null && $ownerId !== $viewer->id) {
                $this->assertProfileVisible(User::findOrFail($ownerId));
            }
            $builder->where('user_id', $ownerId ?? $viewer->id);
        }

        return $builder
            ->where(static fn (Builder $query) => $query
                ->where('subject_class', '<>', (new GameList)->getMorphClass())
                ->orWhere('user_id', $viewer->id)
                ->orWhereIn('subject_id', GameList::where('visibility', Visibility::Public)->select('id')))
            // "A followed B" names B too, who may have blocked the caller.
            ->where(static fn (Builder $query) => $query
                ->where('subject_class', '<>', User::class)
                ->orWhereNotIn('subject_id', $viewer->blockedUserIds()));
    }

    /**
     * The comments on one review, list or comment, in a thread the caller may see. Comments by
     * users in a block with the caller are left out, as are their replies (unreachable without
     * them).
     *
     * @param  Builder<Comment>  $builder
     * @param  array<string, mixed>  $uriVariables
     * @return Builder<Comment>
     */
    private function comments(Builder $builder, array $uriVariables, Operation $operation): Builder
    {
        /** @var User $viewer */
        $viewer = auth()->user();
        if ($uriVariables !== []) {
            Comment::find($uriVariables['id'])?->ensureVisibleTo($viewer);
        } else {
            $type = (string) $this->parameter($operation, 'filter[commentable_type]');
            $id = (int) $this->parameter($operation, 'filter[commentable_id]');
            /** @var class-string<LibraryEntry|GameList|Comment> $class */
            $class = Relation::getMorphedModel($type);
            $class::findOrFail($id)->ensureVisibleTo($viewer);
            $builder->where('commentable_type', $type)->where('commentable_id', $id);
        }

        $blocked = $viewer->blockedUserIds();

        return $builder->whereNotIn('user_id', $blocked)
            ->with(['user' => $this->socialContext(...), 'commentable', 'reactionCounts'])
            ->withCount(['comments as replies_count' => static fn (Builder $replies) => $replies->whereNotIn('user_id', $blocked)])
            ->withMax(['reactions as my_reaction' => static fn (Builder $reactions) => $reactions->where('user_id', $viewer->id)], 'type');
    }

    /**
     * @param  Builder<Notification>  $builder
     * @return Builder<Notification>
     */
    private function notifications(Builder $builder, Operation $operation): Builder
    {
        $builder->where('notifiable_type', User::class)->where('notifiable_id', auth()->id());

        return match ($this->parameter($operation, 'filter[unread]')) {
            'true' => $builder->whereNull('read_at'),
            'false' => $builder->whereNotNull('read_at'),
            default => $builder,
        };
    }

    /**
     * Counters and flags for every user a document embeds.
     *
     * @param  BelongsTo<User, Model>  $relation
     */
    private function socialContext(BelongsTo $relation): void
    {
        $relation->getQuery()->withSocialContext();
    }

    /**
     * A missing owner means a missing resource, which the query itself turns into a 404.
     */
    private function assertProfileVisible(?User $owner): void
    {
        $owner?->ensureProfileVisibleTo(auth()->user());
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
