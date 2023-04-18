<?php

namespace App\Models;

use App\Services\StaticValueService;
use Illuminate\Database\Eloquent\Model;

class UserReference extends Model
{
    protected $table = 'user_reference';

    protected $guarded = ['id'];


    public function getRelationTypeAttribute($value)
    {
        return StaticValueService::relationTypeById($value);
    }
}
