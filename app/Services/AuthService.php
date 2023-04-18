<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthService
{
    public static function generateAuthToken($request)
    {
        $req = Request::create('/oauth/token', 'POST', [
            'grant_type' => env('GRANT_TYPE'),
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'username' => $request['username'],
            'password' => $request['password'],
            'scope' => ''
        ]);
        $res = app()->handle($req);

        return json_decode($res->getContent());
    }

    public static function generateAuthTokenFromRefreshToken($refreshToken)
    {
        $request = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'scope' => '',
        ]);
        $res = app()->handle($request);

        return json_decode($res->getContent());
    }

    public static function getUserByToken($token)
    {
        $request = Request::create('/user-info', 'GET');
        $request->headers->set('Authorization', "$token->token_type $token->access_token");
        $res = app()->handle($request);

        if ($res->getStatusCode() != 200) {
            abort($res->getStatusCode(), $res->getContent());
        }

        return json_decode($res->getContent());
    }

    public static function getAuthToken(Request $request): ?string
    {
        $header = $request->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
        return null;
    }

    public static function getCurrentTokenId($token)
    {
        return ((new \Lcobucci\JWT\Parser())->parse($token)->getClaims()['jti']->getValue());
    }

    public static function getCompany()
    {
        return Auth::user()->companyOwner;
    }

    public static function getCompanyId()
    {

    }

    public static function getAuthUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }

    public static function getAuthUserId(): int
    {
        return Auth::id();
    }
}
