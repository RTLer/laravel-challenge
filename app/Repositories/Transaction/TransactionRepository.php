<?php

namespace App\Repositories\Transaction;

use App\Filters\Transaction\TransactionFilter;
use App\Models\Transaction;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

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
    public function __construct(Transaction $model, Request $request, TransactionFilter $filter)
    {
        $this->filters = $filter;
        parent::__construct($model, $request);
    }

    /**
     * Calculate Summary of transaction and group by type
     * @return Builder|Paginator
     */
    public function summary()
    {
        return $this->viaFilters(false)
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type');
    }
}
