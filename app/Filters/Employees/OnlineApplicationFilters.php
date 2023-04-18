<?php


namespace App\Filters\Employees;

use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class OnlineApplicationFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function from_date($value)
    {
        $this->builder->where('post_applicants.created_at', '>=', $value);
    }

    public function to_date($value)
    {
        $this->builder->where('post_applicants.created_at', '<=', $value);
    }

    public function company_name($value)
    {
        $this->builder->whereHas('company', function ($q) use ($value) {
            $q->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
        });
    }

    public function view_status($value)
    {
        $this->builder->where('is_viewed', $value);
    }

    public function sort($value)
    {
//        $data = HelperService::getSortKeyVal($value);
//        $sortType = $data->sort_type;
//
//        if ($sortType) {
//            if ($data->sort_key == 'title') {
//                $this->builder->orderBy('title', $sortType);
//
//            } elseif ($data->sort_key == 'updated_at') {
//                $this->builder->orderBy('updated_at', $sortType);
//            }
//        }
    }
}
