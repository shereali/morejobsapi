<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class IndustryType extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(IndustryType::class, 'parent_id');
    }

    public function subIndustryTypes()
    {
        return $this->hasMany(IndustryType::class, 'parent_id', 'id');
    }
}
