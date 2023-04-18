<?php


namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilters
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filterArray() as $name => $value) {
            if (!method_exists($this, $name)) {
                continue;
            }
            $this->$name($value);
        }

        return $this->builder;
    }

    public function filterArray()
    {
        return $this->request->all();
    }
}
