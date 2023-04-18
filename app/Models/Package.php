<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function group()
    {
        return $this->belongsTo(PackageGroup::class, 'package_group_id');
    }

    public function details()
    {
        return $this->hasMany(PackageDetail::class, 'package_id');
    }
}
