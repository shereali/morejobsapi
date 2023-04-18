<?php


namespace App\Filters\Employees;

use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class FavoritePostFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function from_date($value)
    {
        $this->builder->where('user_fav_post.created_at', '>=', $value);
    }

    public function to_date($value)
    {
        $this->builder->where('user_fav_post.created_at', '<=', $value);
    }

    public function company_name($value)
    {
        $this->builder->whereHas('post.company', function ($q) use ($value) {
            $q->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
        });
    }
}
