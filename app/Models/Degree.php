<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Degree extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class)->select('id', 'title');
    }
}
