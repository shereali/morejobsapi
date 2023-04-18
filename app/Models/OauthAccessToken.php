<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    protected $casts = ['id' => 'string'];

    public function oauthRefreshToken()
    {
        return $this->hasOne(OauthRefreshToken::class, 'access_token_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function format($tokenId)
    {
        $this['current_token'] = false;

        if ($this->id == $tokenId) {
            $this['current_token'] = true;
        }

        if ($this->json_data) {
            $this['json_data'] = json_decode($this->json_data);
        }

        return $this;
    }
}
