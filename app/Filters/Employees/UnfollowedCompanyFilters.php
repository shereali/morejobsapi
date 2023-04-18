<?php


namespace App\Filters\Employees;

use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class UnfollowedCompanyFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function industry_type($value)
    {
        $this->builder->whereHas('industryTypes', function ($q) use ($value) {
            $q->where('industry_types.id', $value);
        });
    }

    public function company_name($value)
    {
        $this->builder->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
    }
}
