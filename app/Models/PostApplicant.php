<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class PostApplicant extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function postMatchingCriteria()
    {
        return $this->hasMany(PostMatchingCriteria::class, 'post_id', 'post_id')->where('is_mandatory', 1);
    }
}
