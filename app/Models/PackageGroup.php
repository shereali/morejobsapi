<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageGroup extends Model
{
    public function type()
    {
        return $this->belongsTo(PackageType::class, 'package_type_id');
    }

    public function packages()
    {
        return $this->hasMany(Package::class, 'package_group_id');
    }
}
