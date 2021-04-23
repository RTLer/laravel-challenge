<?php

namespace App\Repositories;

use App\Filters\QueryFilters;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

/**
 * The base repository
 *
 * @category Repositories
 */
class BaseRepository implements BaseRepositoryInterface
{

    const PER_PAGE = 10;

    /**
     * The model
     *
     * @var QueryFilters
     */
    protected $filters;

    /**
     * The model
     *
     * @var Model|Builder
     */
    protected $model;
    /**
     * @var Request
     */
    private $request;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model The model
     * @param Request $request
     */
    public function __construct(Model $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    protected function per_page(): int
    {
        return $this->request->has('per_page') && intval($this->request->get('per_page')) != 0 ? intval($this->request->get('per_page')) : self::PER_PAGE;
    }

    /**
     * This method will find all models
     *
     * @return Collection|Model[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get the model instance being queried.
     *
     * @return Model|static
     */
    public function getModel()
    {
        return $this->model->getModel();
    }

    /**
     * Set the columns to be selected.
     *
     * @param array|mixed $columns
     *
     * @return Builder
     */
    public function select($columns = ['*']): Builder
    {
        return $this->model->select($columns);
    }

    /**
     * This method will find the model
     *
     * @param int $id The id of model
     *
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param array|string $columns
     * @return Collection|static[]
     */
    public function get($columns = ['*'])
    {
        return $this->model->get($columns);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param mixed $id
     * @param array $columns
     *
     * @return Model|Collection|static|static[]
     * @throws ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param Closure|string|array $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     *
     * @return Builder|Model
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        return $this->model->where($column, $operator, $value, $boolean);
    }

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
    public function whereIn($column, $values, $boolean = 'and', $not = false): Builder
    {
        return $this->model->whereIn($column, $values, $boolean, $not);
    }

    /**
     * Add a "where not in" clause to the query.
     *
     * @param string $column
     * @param mixed $values
     * @param string $boolean
     *
     * @return Builder
     */
    public function whereNotIn($column, $values, $boolean = 'and'): Builder
    {
        return $this->model->whereNotIn($column, $values, $boolean);
    }

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes
     * @return Model|$this
     */
    public function create(array $attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * Get the first record matching the attributes or create it.
     *
     * @param array $toSearchAttributes The items to search by them for checking is the model the first one
     * @param array $values The model values
     *
     * @return Builder|Model
     */
    public function firstOrCreate(array $toSearchAttributes, array $values)
    {
        return $this->model->firstOrCreate($toSearchAttributes, $values);
    }

    /**
     * Update the model in the database.
     *
     * @param array $attributes
     * @param array $options
     *
     * @return bool
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        return $this->model->update($attributes, $options);
    }

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param array $attributes
     * @param array $values
     * @return Model|static
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

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
    public function viaFilters($pagination = false,$perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $perPage = is_null($perPage) ? $this->per_page() : $perPage;
        $queryFilters = $this->model->filter($this->filters);
        return $pagination === false ? $queryFilters : $queryFilters->paginate($perPage, $columns, $pageName, $page);;
    }
}
