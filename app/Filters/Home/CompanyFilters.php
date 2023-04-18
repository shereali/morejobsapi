<?php


namespace App\Filters\Home;


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

    public function search_value($value)
    {
        $this->builder->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
    }

    public function start_with($value)
    {
        $this->builder->where('title_en', 'like', "$value%")->orWhere('title_bn', 'like', "$value%");
    }

    public function organization_type_id($value)
    {
        $this->builder->whereOrganizationTypeId($value);
    }
}
