<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    protected $table = 'user_experience';

    protected $guarded = ['id'];

    public function industryType()
    {
        return $this->belongsTo(IndustryType::class);
    }

    public function experienceSkills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill', 'user_experience_id', 'skill_id');
    }
}
