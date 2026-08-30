<?php

declare(strict_types=1);

namespace App\Extensions;

use ApiPlatform\Laravel\Eloquent\Extension\QueryExtensionInterface;
use ApiPlatform\Metadata\Operation;
use App\Models\LibraryEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Scopes every query to what the authenticated user owns. Discovered automatically: API Platform
 * autoconfigures anything implementing QueryExtensionInterface.
 */
final class OwnedResourcesExtension implements QueryExtensionInterface
{
    public function apply(Builder $builder, array $uriVariables, Operation $operation, mixed $context = []): Builder
    {
        return match ($operation->getClass()) {
            LibraryEntry::class => $builder->where('user_id', auth()->id()),
            // Makes the collection the "current user" endpoint: it holds the caller and no one
            // else, so a client that does not know its own id can still fetch itself.
            User::class => $builder->whereKey(auth()->id()),
            default => $builder,
        };
    }
}
