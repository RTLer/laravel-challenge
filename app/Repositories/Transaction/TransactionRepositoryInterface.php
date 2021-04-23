<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Models\User;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * The repository of customer model
 * PHP version >= 7.0
 *
 * @category Repositories
 */
interface TransactionRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * This method will find the model
     *
     * @param mixed $id The id of model
     *
     * @return Transaction
     */
    public function find($id);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param mixed $id
     * @param array $columns
     *
     * @return Transaction|Collection|static|static[]
     * @throws ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*']);

    /**
     * Get the first record matching the attributes or create it.
     *
     * @param array $toSearchAttributes The items to search by them for checking is the model the first one
     * @param array $values The model values
     *
     * @return Builder|Transaction
     */
    public function firstOrCreate(array $toSearchAttributes, array $values);
}
