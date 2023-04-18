<?php

namespace App\Models;

use App\Services\StaticValueService;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function getStatusAttribute($value)
    {
        return StaticValueService::blogStatusById($value);
    }

    public function getCoverImageAttribute($value)
    {
        return $value ? asset('uploads/' . $value) : null;
    }
}
