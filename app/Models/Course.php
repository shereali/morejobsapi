<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class);
    }

    public function courseCategories()
    {
        return $this->belongsToMany(TrainingCategory::class, 'course_category', 'course_id', 'training_category_id');
    }
}
