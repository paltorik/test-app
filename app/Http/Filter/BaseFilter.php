<?php


namespace App\Http\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

abstract class BaseFilter
{
    protected Request $request;

    protected Builder $builder;

    protected array $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            $this->callMethods($filter, $value);
        }
        return $this->builder;
    }

    protected function callMethods($filter, $value)
    {
        if (method_exists($this, $filter)) {
            if (is_array($value) && isset($this->filters[$filter]) && is_array($this->filters[$filter])) {
                $this->$filter(...$value);
            } else {
                $this->$filter($value);
            }
        }
    }

    public function getFilters()
    {
        $filters = [];


        foreach ($this->filters as $key => $filter) {
            $value = is_array($filter) ? $this->getArrayFromRequest($filter) : $this->request->get($filter);

            if ($value) {
                $filters[$filter] = $value;
            }
        }
        return $filters;
    }

    protected function getArrayFromRequest($keys): ?array
    {

        $values = $this->request->only($keys);

        foreach ($values as $value) {
            if (!is_bool($value) && !is_array($value) && trim((string) $value) === '') {
                return null;
            }
        }
        return count($keys) === count($values) ? array_values($values) : null;
    }

    protected function validationBoolean($direction): void
    {
        if (!is_bool($direction)) {
            throw new BadRequestException("Error sorting");
        }
    }

    protected function mapJson(callable $callback, array $array): static
    {
        foreach ($array as $sort) {
            [$column, $direction] = json_decode($sort, true);
            $this->validationBoolean($direction);
            if ($callback($column, boolval($direction)) === false) {
                break;
            }
        }
        return $this;
    }

}
