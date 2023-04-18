<?php


namespace App\Filters;


use App\Services\HelperService;
use Illuminate\Http\Request;

class UserFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function search_value($value)
    {
        $this->builder->where('first_name', 'like', "%$value%")
            ->orWhere('last_name', 'like', "%$value%")
            ->orWhere('username', 'like', "%$value%");
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


    public function sort($value)
    {
        $data = HelperService::getSortKeyVal($value);
        $sortType = $data->sort_type;

        if ($sortType) {
            if ($data->sort_key == 'name') {
                $this->builder->orderBy('first_name', $sortType);
            } elseif ($data->sort_key == 'username') {
                $this->builder->orderBy('username', $sortType);
            } elseif ($data->sort_key == 'created_at') {
                $this->builder->orderBy('created_at', $sortType);
            }
        }
    }
}
