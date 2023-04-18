<?php

namespace App\Models;

use App\Services\StaticValueService;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{

    protected $guarded = ['id'];

    public function position(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AdsPosition::class, 'position_id', 'id');
    }

    public function getStatusAttribute($value)
    {
        return StaticValueService::adsStatusById($value);
    }

    public function getImageAttribute($value)
    {
        return $value ? asset('uploads/' . $value) : null;
    }
}
