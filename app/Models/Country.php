<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function districts()
    {
        return $this->hasMany(Area::class, 'country_id')->whereLevel(1);
    }
}
