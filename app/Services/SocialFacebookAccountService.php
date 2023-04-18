<?php

namespace App\Services;

use App\Events\AuthEvent;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser, $request)
    {
        $authUser = User::where('username', $providerUser->getEmail() ? $providerUser->getEmail() : $providerUser->getId())->first();

        /**
         *login with existing user (facebook, google)
         */
        if ($authUser) {
            $request->merge(['username' => $authUser->username, 'password' => config('services.fbGoogleUserPass.password')]);

            return AuthService::generateAuthToken($request);
        }

        /**
         *registration for new user (facebook, google)
         */
        $request->request->add([
            'first_name' => $providerUser->getName(),
            'password' => config('services.fbGoogleUserPass.password'),
            'reg_medium' => StaticValueService::regMediumId($request->provider),
        ]);

        if ($providerUser->getEmail()) {
            $request->request->add([
                'username' => $providerUser->getEmail(),
                'type' => StaticValueService::regMediumId('email')
            ]);
        } else {
            $request->request->add([
                'username' => $providerUser->getId(),
                'type' => StaticValueService::regMediumId('mobile')
            ]);
        }

        event(new AuthEvent($request->all()));

//        $obj = new RegisterController();
//        $obj->validator($request->all())->validate();
//        $obj->create($request);

        return AuthService::generateAuthToken($request);
    }
}
