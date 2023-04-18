<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAcademic extends Model
{
    protected $table = 'user_academic';

    protected $guarded = ['id'];

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function resultType()
    {
        return $this->belongsTo(ResultType::class);
    }
}
