<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $table = 'user_profile';

    protected $guarded = ['id'];

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }

    public function maritalStatus(): BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function presentArea(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'present_area_id');
    }

    public function permanentArea(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'permanent_area_id');
    }

    public function jobLevel(): BelongsTo
    {
        return $this->belongsTo(JobLevel::class);
    }

    public function jobNature(): BelongsTo
    {
        return $this->belongsTo(JobNature::class);
    }

    public function getResumeFileAttribute($value)
    {
        return $value ? asset('uploads/'.$value) : null;
    }
}
