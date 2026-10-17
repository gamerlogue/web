<?php

declare(strict_types=1);

namespace App\Extensions;

use ApiPlatform\Laravel\Eloquent\Extension\QueryExtensionInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ParameterNotFound;
use App\Exceptions\ApiDomainException;
use App\Models\LibraryEntry;
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
            default => $builder,
        };
    }

    /**
     * @param  Builder<LibraryEntry>  $builder
     * @return Builder<LibraryEntry>
     */
    private function libraryEntries(Builder $builder, Operation $operation): Builder
    {
        $ownerId = request()->boolean('current_user') ? null : $this->parameter($operation, 'filter[user]');
        if ($ownerId !== null && $ownerId !== auth()->id()) {
            $owner = User::findOrFail($ownerId);
            if (Gate::denies('viewProfile', $owner)) {
                throw ApiDomainException::profilePrivate();
            }
        }
        $builder->where('user_id', $ownerId ?? auth()->id())->with('user');

        return match ($this->parameter($operation, 'filter[has_review]')) {
            'true' => $builder->whereNotNull('review')->where('review', '<>', ''),
            'false' => $builder->where(static fn (Builder $query) => $query->whereNull('review')->orWhere('review', '')),
            default => $builder,
        };
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

    private function parameter(Operation $operation, string $key): mixed
    {
        $value = $operation->getParameters()?->get($key)?->getValue();

        return $value instanceof ParameterNotFound ? null : $value;
    }
}
