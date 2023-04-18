<?php


namespace App\Filters\Home;


use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class CourseFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function training_category_id($value)
    {
        $this->builder->whereHas('courseCategories', function ($q) use ($value) {
            $q->where('training_categories.id', $value);
        });
    }

    public function course_industry($value)
    {

    }

    public function course_category($value)
    {
        $this->builder->whereHas('courseCategories', function ($q) use ($value) {
            $q->where('training_categories.id', $value);
        });
    }

    public function course_type($value)
    {
        $this->builder->where('training_type_id', $value);
    }
}
