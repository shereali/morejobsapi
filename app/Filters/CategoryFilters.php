<?php


namespace App\Filters;


use App\Services\HelperService;
use Illuminate\Http\Request;

class CategoryFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function title($value)
    {
        $this->builder->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
    }

    public function category_type_id($value)
    {
        $this->builder->where('category_type_id', $value);
    }

    public function tag_id($value)
    {
        $this->builder->where('tag_id', $value);
    }

    public function sort($value)
    {
        $data = HelperService::getSortKeyVal($value);
        $sortType = $data->sort_type;

        if ($sortType) {
            if ($data->sort_key == 'title_en') {
                $this->builder->orderBy('title_en', $sortType);
            } elseif ($data->sort_key == 'title_bn') {
                $this->builder->orderBy('title_bn', $sortType);
            } elseif ($data->sort_key == 'updated_at') {
                $this->builder->orderBy('updated_at', $sortType);
            }
        }
    }
}
