<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class UserFavCompany extends Model
{
    use Filterable;

    protected $table = 'user_fav_company';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
