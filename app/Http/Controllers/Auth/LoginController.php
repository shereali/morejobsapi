<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\AccountService;
use App\Services\AuthService;
use App\Services\HelperService;
use App\Services\SocialFacebookAccountService;
use App\Services\StaticValueService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function systemLogin(LoginRequest $request): JsonResponse
    {
        $regMedium = AccountService::isEmailOrMobile($request->username);
        if ($regMedium == StaticValueService::regMediumId('mobile')) {
            $request['username'] = AccountService::getFormattedPhoneNo($request->username);
        }

        try {
            $token = AuthService::generateAuthToken($request);

            if (empty($token)) {
                return $this->errorResponse('Something went wrong. Token not generated');
            }

            if (property_exists($token, 'error') || property_exists($token, 'errors')) {
                return $this->errorResponse('This credential is invalid!');
            }

            $user = AuthService::getUserByToken($token);

            if ($user->user_type->id != 1) {
                $this->logout();
                abort(401, 'You are not allowed to login');
            }

            $token->user = $user;

            return $this->successResponse('Logged in successfully', $token);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $userName = HelperService::bn2en($request->username);
        $regMedium = AccountService::isEmailOrMobile($userName);
        if ($regMedium == StaticValueService::regMediumId('mobile')) {
            $request['username'] = AccountService::getFormattedPhoneNo($userName);
        }

        try {
            $token = AuthService::generateAuthToken($request);

            if (empty($token)) {
                return $this->errorResponse('Something went wrong. Token not generated');
            }

            if (property_exists($token, 'error') || property_exists($token, 'errors')) {
                return $this->errorResponse('This credential is invalid!');
            }

            $user = AuthService::getUserByToken($token);

            if (!in_array($user->user_type->id, [1, 2, 3])) {
                $this->logout();
                abort(401, 'You are not allowed to login');
            }

            $token->user = $user;

            return $this->successResponse('Logged in successfully', $token);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function logout(): JsonResponse
    {
        try {
            DB::beginTransaction();

            if (Auth::check()) {
                $token = Auth::user()->token();
                $token->revoke();

                DB::table('oauth_refresh_tokens')
                    ->where('access_token_id', $token->id)
                    ->update(['revoked' => true]);

                DB::commit();
                return $this->successResponse('Successfully logged out');
            }

            abort(401, 'Unauthenticated');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    public function refreshToken(Request $request): JsonResponse
    {
        $this->validate($request, [
            'refresh_token' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $token = AuthService::generateAuthTokenFromRefreshToken($request->refresh_token);

            if (property_exists($token, 'error')) {
                return $this->errorResponse($token->message);
            }

            DB::commit();
            return $this->successResponse('Successfully token generated', $token);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }
    }

    public function sendOTP()
    {
        $user = Auth::user();

        if ($user->account_verified_at) {
            return $this->errorResponse('Your account is already verified.');
        }

        try {
            $user->account_verification_token = AccountService::generateVerificationToken();
            $user->save();

            AccountService::sendVerificationCode($user);

            return $this->successResponse('Verification code sent successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function verifyAccount(Request $request)
    {
        $this->validate($request, [
            'verification_code' => 'required',
        ]);

        $user = Auth::user();

        if ($user->account_verified_at) {
            return $this->errorResponse('Your account is already verified.');
        }

        if ($user->account_verification_token != $request->verification_code) {
            return $this->errorResponse('You entered wrong verification code!');
        }

        try {
            DB::beginTransaction();

            $user->account_verification_token = null;
            $user->account_verified_at = Carbon::now()->toDateTimeString();

            $user->save();

            $user->userContacts()->update([
                'is_verified' => 1
            ]);

            DB::commit();
            return $this->successResponse('Account verified successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }
    }

    //Third party login here...
    public function redirect($provider)
    {
        $request = new Request([
            'medium' => $provider
        ]);

        $this->validate($request, [
            'medium' => 'required|in:facebook,google'
        ]);

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback(Request $request, SocialFacebookAccountService $accountService)
    {
        $this->validate($request, [
            'provider' => 'required|string|in:facebook,google'
        ]);

        try {
            DB::beginTransaction();

            $user = Socialite::driver($request->provider)->stateless()->user();
            $token = $accountService->createOrGetUser($user, $request);

            if (property_exists($token, 'error')) {
                return $this->errorResponse('This credential is invalid!');
            }

            $token->user = $user;

            DB::commit();
            return $this->successResponse('Successfully token generated', $token);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }
    }

    public function deleteAccount()
    {
        try {
            DB::beginTransaction();

            User::where('id', Auth::user()->id)->update([
                'status' => 0
            ]);

            DB::commit();
            return $this->successResponse('Your account has been deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }
    }
}
