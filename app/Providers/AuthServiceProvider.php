<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Carbon;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }


    public function boot()
    {
        Passport::tokensExpireIn(Carbon::now()->addDays(360));
//        Passport::tokensExpireIn(Carbon::now()->addMinutes(60));
        LumenPassport::$allowMultipleTokens = true;

//        $this->app['auth']->viaRequest('api', function ($request) {
//            if ($request->input('api_token')) {
//                return User::where('api_token', $request->input('api_token'))->first();
//            }
//        });
    }
}
