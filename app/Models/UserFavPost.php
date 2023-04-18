<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class UserFavPost extends Model
{
    use Filterable;

    protected $table = 'user_fav_post';

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
