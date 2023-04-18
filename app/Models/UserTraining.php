<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTraining extends Model
{
    protected $table = 'user_training';

    protected $guarded = ['id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
