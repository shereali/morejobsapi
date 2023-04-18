<?php


namespace App\Filters;


use App\Services\HelperService;
use Illuminate\Http\Request;

class ExampleFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function narration($value)
    {
        $this->builder->where('contact_name', 'like', "%$value%");
    }

    public function from_date($value)
    {
        $this->builder->where('date', '>=', $value);
    }

    public function to_date($value)
    {
        $this->builder->where('date', '<=', $value);
    }

    public function order_by($value)
    {
        if ($value === 'journal_date') {
            $this->builder->orderBy('journals.date', 'DESC');
        }
    }

    public function sort($value)
    {
        $data = HelperService::getSortKeyVal($value);
        $sortType = (!$data->sort_type || $data->sort_type != 'desc') ? 'asc' : 'desc';

        if ($data->sort_key == 'narration') {
            $this->builder->orderBy('contact_name', $sortType);

        } elseif ($data->sort_key == 'date') {
            $this->builder->orderBy('date', $sortType);
        } elseif ($data->sort_key == 'total') {
            $this->builder->orderBy('total', $sortType);
        } elseif ($data->sort_key == 'status') {
            $this->builder->orderBy('status', $sortType);
        }
    }
}
