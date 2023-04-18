<?php

namespace App\Filters\Admin;

use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class AreaFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function country_id($value)
    {
        $this->builder->where('country_id', $value);
    }

    public function title($value)
    {
        $this->builder->where(function ($q) use ($value) {
            $q->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
        })->orWhere(function ($q) use ($value) {
            $q->whereHas('subAreas', function ($q) use ($value) {
                $q->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
            })->orWhereHas('subAreas.subAreas', function ($q) use ($value) {
                $q->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
            })->orWhereHas('subAreas.subAreas.subAreas', function ($q) use ($value) {
                $q->where('title_en', 'like', "%$value%")->orWhere('title_bn', 'like', "%$value%");
            });
        });
    }
}
