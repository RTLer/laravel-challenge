<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Routing\Exception\InvalidParameterException;

/**
 * Trait Filterable
 *
 * @package App\Filters
 */
trait Filterable
{
    /**
     * This method will call when ::filter method calls through a query
     *
     * @param Builder $query The query builder
     * @param QueryFilters $filters The filters
     *
     * @return Builder
     * @throws InvalidParameterException
     */
    public function scopeFilter(Builder $query, QueryFilters $filters): Builder
    {
        return $filters->apply($query);
    }
}
