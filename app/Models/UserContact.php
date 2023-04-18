<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $table = 'user_contact';

    protected $guarded = ['id'];

    protected $hidden = [
        'token', 'token_expire_at'
    ];
}
