<?php

namespace App\Filters\Admin;

use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class SubscriptionFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function company_id($value)
    {
        $this->builder->where('company_id', $value);
    }

    public function status($value)
    {
        if ($value == 'pending') {
            return $this->builder;
        } elseif ($value == 'pending') {
            $this->builder->where('status', 0);
        } elseif ($value == 'approved') {
            $this->builder->where('status', 1);
        } elseif ($value == 'inactive') {
            $this->builder->where('status', 2);
        }
    }
}
