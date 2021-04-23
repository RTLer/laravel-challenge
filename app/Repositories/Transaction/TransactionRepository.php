<?php

namespace App\Repositories\Transaction;

use App\Filters\Transaction\TransactionFilter;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * The repository of customer model
 *
 * @category Repositories
 */
class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param Transaction $model The model
     * @param Request $request
     * @param TransactionFilter $filter
     */
    public function __construct(Transaction $model,Request $request,TransactionFilter $filter)
    {
        $this->filters = $filter;
        parent::__construct($model,$request);
    }

}
