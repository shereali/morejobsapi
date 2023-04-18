<?php


namespace App\Filters\Admin;

use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class IndustryTypeFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function title($value)
    {
        $this->builder->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
    }

    public function parent_id($value)
    {
        $this->builder->where('parent_id', $value);
    }
}
