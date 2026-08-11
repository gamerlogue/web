<?php

declare(strict_types=1);

namespace App\Extensions;

use ApiPlatform\Laravel\Eloquent\Extension\QueryExtensionInterface;
use ApiPlatform\Metadata\Operation;
use App\Models\LibraryEntry;
use Illuminate\Database\Eloquent\Builder;

final class OwnedLibraryEntriesExtension implements QueryExtensionInterface
{
    public function apply(Builder $builder, array $uriVariables, Operation $operation, mixed $context = []): Builder
    {
        if ($operation->getClass() === LibraryEntry::class) {
            $builder->where('user_id', auth()->id());
        }

        return $builder;
    }
}
