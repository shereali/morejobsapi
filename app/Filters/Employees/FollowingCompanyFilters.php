<?php


namespace App\Filters\Employees;

use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class FollowingCompanyFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function company_name($value)
    {
        $this->builder->whereHas('company', function ($q) use ($value) {
            $q->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
        });
    }
}
