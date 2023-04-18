<?php


namespace App\Filters;


use App\Services\HelperService;
use Illuminate\Http\Request;

class DegreeFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function title($value)
    {
        $this->builder->where('title', 'like', "%$value%");
    }

    public function education_level_id($value)
    {
        $this->builder->where('education_level_id', $value);
    }

    public function sort($value)
    {
        $data = HelperService::getSortKeyVal($value);
        $sortType = $data->sort_type;

        if ($sortType) {
            if ($data->sort_key == 'title') {
                $this->builder->orderBy('title', $sortType);

            } elseif ($data->sort_key == 'updated_at') {
                $this->builder->orderBy('updated_at', $sortType);
            } elseif ($data->sort_key == 'education_level_id') {
                $this->builder->orderBy('education_level_id', $sortType);
            }
        }
    }
}
