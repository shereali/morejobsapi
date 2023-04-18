<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{
    protected $guarded = ['id'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'training_type_id', 'id');
    }
}
