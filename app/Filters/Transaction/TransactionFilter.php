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

}
