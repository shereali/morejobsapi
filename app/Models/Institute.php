<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use Filterable;

    protected $fillable = [
        'title'
    ];
}
