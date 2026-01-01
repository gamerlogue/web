<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Laravel\Eloquent\Filter\FilterInterface;
use ApiPlatform\Metadata\Parameter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class CurrentUserFilter implements FilterInterface
{
    /**
     * @param  Builder<Model>  $builder
     * @param  array<string, mixed>  $context
     */
    public function apply(Builder $builder, mixed $values, Parameter $parameter, array $context = []): Builder
    {
        return $builder->where('user_id', auth()->id());
    }
}
