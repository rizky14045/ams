<?php

namespace App\Libraries\Datagrid;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Exception;
use Closure;

class Datagrid
{

    use Concerns\ApplyFilters;

    protected $columns = [];
    protected $viewName = '';
    protected $viewData = [];
    protected $options = [];
    protected $results;

    public static function make($query, array $columns, Request $request = null)
    {
        return new static($query, $columns, $request);
    }

    public function __construct($query, array $columns = [], Request $request = null)
    {
        if (false === $query instanceof EloquentBuilder && false === $query instanceof QueryBuilder) {
            $eloquentBuilder = EloquentBuilder::class;
            $queryBuilder = QueryBuilder::class;
            throw new InvalidArgumentException("Query must be instance of '{$eloquentBuilder}' or '{$queryBuilder}'.");
        }

        $this->query = ($query instanceof EloquentBuilder) ? $query->getQuery() : $query;
        $this->request = $request ?: request();
        $this->columns = $columns;
        $this->options = $this->getDefaultOptions();
    }

    public function getQuery()
    {
        return clone $this->query;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function hasColumn($colName)
    {
        return isset($this->columns[$colName]);
    }

    public function getRealKey($colName)
    {
        if (!$this->hasColumn($colName)) {
            return $colName;
        }

        $colOptions = $this->columns[$colName];
        return array_get($colOptions, 'real_key') ?: $colName;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getColumnFilters()
    {
        $keyColumnFilters = $this->getOption('parameter_key.column_filters');
        $optionFilters = $this->getOption('filters');
        $requestFilters = $this->getRequest()->get($keyColumnFilters);

        if (!is_array($requestFilters)) $requestFilters = [];
        if (!is_array($optionFilters)) $optionFilters = [];

        return array_merge($requestFilters, $optionFilters);
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption($key)
    {
        return array_get($this->getOptions(), $key);
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function withOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    public function setOption($key, $value)
    {
        array_set($this->options, $key, $value);
        return $this;
    }

    public function orderBy($col, $asc = 'asc')
    {
        $this->setOption('order_by', $col);
        $this->setOption('order_asc', $asc);
        return $this;
    }

    public function perPage($perPage)
    {
        $this->setOption('per_page', $perPage);
        return $this;
    }

    public function filter($column, $operator, $value = null)
    {
        $options = ['value' => $value];

        $types = [
            '=' => 'equal',
            '>' => 'bigger_than',
            '>=' => 'bigger_than_equal',
            '<' => 'lower_than',
            '<=' => 'lower_than_equal',
        ];

        $type = isset($types[$operator]) ? $types[$operator] : $operator;

        $this->setOption('filters.'.$column, array_merge($options, [
            'type' => $type,
        ]));

        return $this;
    }

    public function getResults()
    {
        if (!$this->results) {
            $query = $this->getQuery();

            $this->applySelects($query);
            $this->applyFilters($query);
            $this->applySortings($query);

            $this->results = $this->resolves($this->paginate($query));
        }

        return $this->results;
    }

    public function getRows()
    {
        return $this->getResults()['data'];
    }

    public function toArray()
    {
        return $this->getResults();
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    protected function applySelects(QueryBuilder $query)
    {
        $colToSelects = array_filter($this->columns, function($opt) {
            return (!isset($opt['select']) || true === $opt['select']);
        });

        foreach ($colToSelects as $column => $options) {
            $realKey = $this->getRealKey($column);
            if ($column != $realKey) {
                $query->addSelect("{$realKey} as {$column}");
            } else {
                $query->addSelect($column);
            }
        }
    }

    protected function applyFilters(QueryBuilder $query)
    {
        $columnFilters = $this->getColumnFilters();
        foreach ($columnFilters as $column => $options) {
            $this->applyColumnFilter($query, $column, $options);
        }

        $this->filterKeyword($query);
    }

    protected function filterKeyword(QueryBuilder $query)
    {
        $keyKeyword = $this->getOption('parameter_key.keyword');
        $keyword = $this->getRequest()->get($keyKeyword);
        $searchables = array_filter($this->columns, function($col) {
            return isset($col['searchable']) && true === $col['searchable'];
        });

        if ($keyKeyword && count($searchables)) {
            $query->where(function($q) use ($searchables, $keyword) {
                foreach ($searchables as $col => $opt) {
                    $realKey = $this->getRealKey($col);
                    $q->orWhere($realKey, 'like', '%'.$keyword.'%');
                }
            });
        }
    }

    protected function applySortings(QueryBuilder $query)
    {
        $req = $this->getRequest();
        $keySorts = $this->getOption('parameter_key.sorts');
        $sorts = $req->get($keySorts);
        if (is_array($sorts)) {
            foreach ($sorts as $column => $ascending) {
                $query->orderBy($column, $ascending);
            }
        } else {
            $defaultOrderBy = $this->getOption('order_by');
            $defaultOrderAsc = $this->getOption('order_asc') ?: 'asc';
            if ($defaultOrderBy) {
                $query->orderBy($defaultOrderBy, $defaultOrderAsc);
            }
        }
    }

    protected function paginate(QueryBuilder $query)
    {
        $req = $this->getRequest();
        $keyPerPage = $this->getOption('parameter_key.per_page');
        $perPage = $req->get($keyPerPage) ?: $this->getOption('per_page');
        return $query->paginate($perPage ?: 15)->toArray();
    }

    protected function resolves(array $results)
    {
        $colToFormats = array_filter($this->getColumns(), function($opt) {
            return (isset($opt['format']) && $opt['format'] instanceof Closure);
        });

        if (count($colToFormats)) {
            foreach ($results['data'] as $i => $row) {
                foreach ($colToFormats as $col => $opt) {
                    $formatter = $opt['format']->bindTo($this);
                    $colValue = $row->{$col};
                    $results['data'][$i]->{$col} = $formatter($colValue, $row, $i, $results);
                }
            }
        }

        return $results;
    }

    protected function getDefaultOptions()
    {
        return [
            'parameter_key' => [
                'per_page' => 'per_page',
                'page' => 'page',
                'keyword' => 'q',
                'column_filters' => 'col_filters',
                'sorts' => 'sorts',
            ],
            'per_page' => 15,
            'limit_options' => null,
        ];
    }

}
