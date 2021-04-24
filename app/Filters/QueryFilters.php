<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Routing\Exception\InvalidParameterException;

/**
 * Class QueryFilters
 *
 * @package App\Filters
 */
class QueryFilters
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * QueryFilters constructor.
     *
     * @param Request $request The received request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * This method will apply the received filters to query
     *
     * @param Builder $builder The query builder
     *
     * @return Builder
     * @throws InvalidParameterException
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
        $filters = $this->getFilters();
        foreach ($filters as $name => $value) {
            $this->addFilterToQueryBuilder($name, $value);
        }

        return $this->builder;
    }

    /**
     * This method return all requests as filters to delete
     *
     * @return array
     */
    private function getFilters(): array
    {
        $filters = [];
        foreach ($this->request->all() as $name => $value) {
            $name = Str::camel($name);
            if (!method_exists($this, $name)) {
                continue;
            }
            $filters[$name] = $value;
        }
        return $filters;
    }

    /**
     * This method will add the filter to Query Builder
     *
     * @param string $name The name of filter
     * @param mixed $value The value of filter
     *
     * @return void
     * @throws InvalidParameterException
     */
    private function addFilterToQueryBuilder(string $name, $value)
    {
        if ($value != 0 && empty($value)) {
            throw new InvalidParameterException(Str::camel($name));
        }
        $this->$name($value);
    }
}
