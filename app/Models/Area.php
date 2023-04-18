<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(Area::class, 'parent_id');
    }

    public function subAreas()
    {
        return $this->hasMany(Area::class, 'parent_id');
    }

    public function thanas()
    {
        return $this->hasMany(Area::class, 'parent_id');
    }

//    public function thana()
//    {
//        return $this->belongsTo(Area::class, 'parent_id');
//    }
//
//    public function district()
//    {
//        return $this->belongsTo(Area::class, 'parent_id');
//    }
//
//    public function childs()
//    {
//        return $this->hasMany(Area::class, 'parent_id');
//    }

//    public function parentArea()
//    {
//        return $this->belongsTo(Area::class, 'parent_id');
//    }
//
//    public function parent()
//    {
//        return $this->belongsTo(Area::class, 'parent_id');
//    }
}
