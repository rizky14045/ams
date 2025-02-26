<?php

namespace App\Libraries\Datagrid\Concerns;

use Illuminate\Database\Query\Builder;

trait ApplyFilters
{

    protected function applyColumnFilter(Builder $query, $column, $options)
    {
        $filterKey = $this->getRealKey($column);
        if (is_string($options)) {
            $options = [
                'type' => 'like',
                'value' => $options,
            ];
        } else {
            $options = array_merge([
                'type' => 'like',
            ], $options);
        }

        $filterType = array_get($options, 'type');
        $filterMethod = 'applyFilter' . camel_case($filterType);
        if (!is_callable([$this, $filterMethod])) {
            // @TODO: I'm not sure it should return exception or just skip that filter
            return;
        }

        call_user_func_array([$this, $filterMethod], [$query, $filterKey, $options]);
    }

    protected function applyFilterLike(Builder $query, $key, array $options)
    {
        $value = array_get($options, 'value');
        if ($value) {
            $query->where($key, 'like', $value);
        }
    }

    protected function applyFilterEqual(Builder $query, $key, array $options)
    {
        $value = array_get($options, 'value');
        if ($value) {
            $query->where($key, $value);
        }
    }

    protected function applyFilterLowerThan(Builder $query, $key, array $options)
    {
        $value = array_get($options, 'value');
        if ($value) {
            $query->where($key, '<', $value);
        }
    }

    protected function applyFilterLowerThanEqual(Builder $query, $key, array $options)
    {
        $value = array_get($options, 'value');
        if ($value) {
            $query->where($key, '<=', $value);
        }
    }

    protected function applyFilterBiggerThan(Builder $query, $key, array $options)
    {
        $value = array_get($options, 'value');
        if ($value) {
            $query->where($key, '>', $value);
        }
    }

    protected function applyFilterBiggerThanEqual(Builder $query, $key, array $options)
    {
        $value = array_get($options, 'value');
        if ($value) {
            $query->where($key, '>=', $value);
        }
    }

    protected function applyFilterBetween(Builder $query, $key, array $options)
    {
        $from = array_get($options, 'from') ?: array_get($options, 'value.0');
        $to = array_get($options, 'to') ?: array_get($options, 'value.1');
        if ($from && $to) {
            $query->whereBetween($key, [$from, $to]);
        }
    }

    protected function applyFilterIn(Builder $query, $key, array $options)
    {
        $value = array_get($options, 'value');
        if ($value) {
            $query->whereIn($key, $value);
        }
    }

    protected function applyFilterNotIn(Builder $query, $key, array $options)
    {
        $value = array_get($options, 'value');
        if ($value) {
            $query->whereNotIn($key, $value);
        }
    }

    protected function applyFilterNotNull(Builder $query, $key, array $options)
    {
        $query->whereNotNull($key);
    }

    protected function applyFilterNull(Builder $query, $key, array $options)
    {
        $query->whereNull($key);
    }

}
