<?php


namespace App\Filters;


use App\Services\HelperService;
use Illuminate\Http\Request;

class PostFilters extends QueryFilters
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

    public function user_type($value)
    {
        $this->builder->whereUserType($value);
    }

    public function from_date($value)
    {
        $this->builder->where('created_at', '>=', $value);
    }

    public function to_date($value)
    {
        $this->builder->where('created_at', '<=', $value);
    }

    public function status($value)
    {
        if ($value == 'pending') {
            $this->builder->where('status', 1);
        } elseif ($value == 'published') {
            $this->builder->where('status', 2);
        } elseif ($value == 'archived') {
            $this->builder->where('status', 3);
        }
    }


    public function sort($value)
    {
        $data = HelperService::getSortKeyVal($value);
        $sortType = (!$data->sort_type || $data->sort_type != 'desc') ? 'asc' : 'desc';

        if ($data->sort_key == 'name') {
            $this->builder->orderBy('first_name', $sortType);
        } elseif ($data->sort_key == 'username') {
            $this->builder->orderBy('username', $sortType);
        } elseif ($data->sort_key == 'created_at') {
            $this->builder->orderBy('created_at', $sortType);
        }
    }
}
