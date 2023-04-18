<?php


namespace App\Filters;


use App\Services\HelperService;
use Illuminate\Http\Request;

class CompanyFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function search_by($value)
    {
        $this->builder->where('title_en', 'like', "%$value%")
            ->orWhere('title_bn', 'like', "%$value%")
            ->orWhere(function ($q) use ($value) {
                $q->whereHas('contact', function ($q) use ($value) {
                    $q->where('title', 'like', "%$value%");
                });
            });
    }

    public function from_date($value)
    {
        $this->builder->where('created_at', '>=', $value);
    }

    public function to_date($value)
    {
        $this->builder->where('created_at', '<=', $value);
    }


    public function sort($value)
    {
        $data = HelperService::getSortKeyVal($value);
        $sortType = $data->sort_type;

        if ($sortType) {
            if ($data->sort_key == 'name') {
                $this->builder->orderBy('title_en', $sortType);
            } elseif ($data->sort_key == 'contact') {
                $this->builder->whereHas('contact', function ($q) use ($sortType) {
                    $q->orderBy('title', $sortType);
                });
            } elseif ($data->sort_key == 'status') {
                $this->builder->orderBy('status', $sortType);
            } elseif ($data->sort_key == 'created_at') {
                $this->builder->orderBy('created_at', $sortType);
            }
        }
    }
}
