<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Category extends Model
{
    use Userstamps, Filterable;

    protected $guarded = ['id'];

    public function categoryType()
    {
        return $this->belongsTo(CategoryType::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
