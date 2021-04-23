<?php

namespace App\Repositories;

use App\Filters\QueryFilters;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;

/**
 * The base repository interface
 *
 * @category Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * Get the model instance being queried.
     *
     * @return Model|static
     */
    public function getModel();

    /**
     * This method will find all models
     *
     * @return Collection|Model[]
     */
    public function all();

    /**
     * This method will find the model
     *
     * @param mixed $id The id of model
     *
     * @return Builder
     */
    public function select($id);

    /**
     * This method will find the model
     *
     * @param mixed $id The id of model
     *
     * @return Model
     */
    public function find($id);

    /**
     * Execute the query as a "select" statement.
     *
     * @param array|string $columns
     * @return Collection|static[]
     */
    public function get($columns = ['*']);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param mixed $id
     * @param array $columns
     *
     * @return Model|Collection|static|static[]
     * @throws ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*']);

    /**
     * Add a basic where clause to the query.
     *
     * @param Closure|string|array $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     *
     * @return Builder
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and');

    /**
     * Add a "where in" clause to the query.
     *
     * @param string $column
     * @param mixed $values
     * @param string $boolean
     * @param bool $not
     *
     * @return Builder
     */
    public function whereIn($column, $values, $boolean = 'and', $not = false);

    /**
     * Add a "where not in" clause to the query.
     *
     * @param string $column
     * @param mixed $values
     * @param string $boolean
     *
     * @return Builder
     */
    public function whereNotIn($column, $values, $boolean = 'and');

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes
     *
     * @return Model|$this
     */
    public function create(array $attributes = []);

    /**
     * Get the first record matching the attributes or create it.
     *
     * @param array $toSearchAttributes The items to search by them for checking is the model the first one
     * @param array $values The model values
     *
     * @return Builder|Model
     */
    public function firstOrCreate(array $toSearchAttributes, array $values);

    /**
     * Update the model in the database.
     *
     * @param array $attributes
     * @param array $options
     *
     * @return bool
     */
    public function update(array $attributes = [], array $options = []);

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param array $attributes
     * @param array $values
     *
     * @return Model|static
     */
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * Filter enable in repository
     *
     *
     * @param bool $pagination
     * @param null $perPage
     * @param string[] $columns
     * @param string $pageName
     * @param null $page
     * @return Builder|Paginator
     */
    public function viaFilters($pagination = false,$perPage = null, $columns = ['*'], $pageName = 'page', $page = null);
}
