<?php

namespace App\Filters\Transaction;

use App\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserBalanceFilters
 * @package App\Filters\Transaction
 */
class TransactionFilter extends QueryFilters
{
    public function webserviceId($term): Builder
    {
        return $this->builder->where('webservice_id', '=', "$term");
    }

    public function startId($term): Builder
    {
        return $this->builder->where('id', '>', $term);
    }

    public function EndId($term): Builder
    {
        return $this->builder->where('id', '<', $term);
    }

    public function startIdEqual($term): Builder
    {
        return $this->builder->where('id', '>=', $term);
    }

    public function EndIdEqual($term): Builder
    {
        return $this->builder->where('id', '<=', $term);
    }

    public function amountMore($term): Builder
    {
        return $this->builder->where('amount', '>', $term);
    }

    public function amountFewer($term): Builder
    {
        return $this->builder->where('amount', '<', $term);
    }

    public function amountMoreEqual($term): Builder
    {
        return $this->builder->where('amount', '>=', $term);
    }

    public function amountFewerEqual($term): Builder
    {
        return $this->builder->where('amount', '<=', $term);
    }

}
