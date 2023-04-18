<?php

namespace App\Filters\Admin;

use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class BlogFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function blog_type($value)
    {
        $map = ['admissions' => 1, 'events' => 2, 'scholarships' => 3, 'articles' => 4];

        $this->builder->where('type', @$map[$value]);
    }

    public function organization_type_id($value)
    {
        $this->builder->where('organization_type_id', $value);
    }

    public function status($value)
    {
        if ($value == 'pending') {
            $this->builder->where('status', 0);
        } elseif ($value == 'approved') {
            $this->builder->where('status', 1);
        } elseif ($value == 'inactive') {
            $this->builder->where('status', 2);
        }
    }
}
