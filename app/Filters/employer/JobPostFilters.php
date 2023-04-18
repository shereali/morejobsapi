<?php

namespace App\Filters\employer;

use App\Filters\QueryFilters;
use App\Services\HelperService;
use Illuminate\Http\Request;

class JobPostFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function from_date($value)
    {
        $this->builder->where('created_at', '>=', $value);
    }

    public function to_date($value)
    {
        $this->builder->where('created_at', '<=', $value);
    }

    public function title($value)
    {
        $this->builder->where('title', 'like', "%$value%");
    }

    public function status($value)
    {
        if ($value == 'posted') {
            $this->builder->whereIn('status', [1, 2]);
        } elseif ($value == 'drafted') {
            $this->builder->where('status', 0);
        } elseif ($value == 'archived') {
            $this->builder->where('status', 3);
        }
    }


    public function sort($value)
    {
        $data = HelperService::getSortKeyVal($value);
        $sortType = $data->sort_type;

//        if ($sortType) {
//            if ($data->sort_key == 'name') {
//                $this->builder->orderBy('title_en', $sortType);
//            } elseif ($data->sort_key == 'contact') {
//                $this->builder->whereHas('contact', function ($q) use ($sortType) {
//                    $q->orderBy('title', $sortType);
//                });
//            } elseif ($data->sort_key == 'status') {
//                $this->builder->orderBy('status', $sortType);
//            } elseif ($data->sort_key == 'created_at') {
//                $this->builder->orderBy('created_at', $sortType);
//            }
//        }
    }
}
