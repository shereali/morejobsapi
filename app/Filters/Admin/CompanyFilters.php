<?php

namespace App\Filters\Admin;

use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class CompanyFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function company_name($value)
    {
        $this->builder->where('title_en', 'like', "$value%")->orWhere('title_bn', 'like', "$value%");
    }

    public function organization_type_id($value)
    {
        $this->builder->where('organization_type_id', $value);
    }

    public function status($value)
    {
        if ($value == 'pending') {
            $this->builder->where('status', 0);
        } elseif ($value == 'approved') {
            $this->builder->where('status', 1);
        } elseif ($value == 'inactive') {
            $this->builder->where('status', 2);
        }
    }
}
