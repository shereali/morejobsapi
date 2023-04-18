<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AccountService;
use App\Services\AuthService;
use App\Services\CommonService;
use App\Services\StaticValueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function initiateEmployeeRegister()
    {
        return $this->response([
            'categories' => CommonService::jobCategories()
        ], 'Initiate employee register');
    }

    public function employeeRegister(Request $request)
    {
        $this->validate($request, [
            'registration_category' => 'required|in:general,special,disabled',
            'name' => 'required|string',
            'set_username_as' => 'required|in:email,mobile_no',
            'email' => $request->set_username_as == 'email' ? 'required|string|unique:users,username' : '',
            'mobile_no' => $request->set_username_as == 'mobile_no' ? 'required|string|unique:users,username' : '',
            'password' => 'required|min:6',
            'category_id' => 'required|integer',
            'gender_id' => 'required',
        ]);

        AccountService::validatePhoneNo($request->mobile_no, 'mobile_no');

        $name = explode(' ', $request->name);

        $request->request->add([
            'first_name' => $name[0],
            'last_name' => @$name[1],
            'mobile_no' => AccountService::getFormattedPhoneNo($request->mobile_no),
            'username' => $request->set_username_as == 'email' ? $request->email : AccountService::getFormattedPhoneNo($request->mobile_no),
            'reg_medium' => $request->set_username_as == 'email' ? StaticValueService::regMediumId('email') : StaticValueService::regMediumId('mobile'),
            'password' => Hash::make($request->password),
            'raw_password' => $request->password,
            'status' => 1,
            'user_type' => StaticValueService::userTypeIdByKey('employee')
        ]);

        if ($request->registration_category == 'general') {
            $this->validate($request, [
                'agreed_term_condition' => 'required',
            ]);
        }

        try {
            DB::beginTransaction();

            $user = User::create($request->all() + [
                    'account_verification_token' => AccountService::generateVerificationToken()
                ]);

            $user->profile()->create([
                'gender_id' => $request->gender_id
            ]);

            $user->preferredJobCategories()->attach($request->category_id);

            if ($request->email) {
                $user->contacts()->create([
                    'title' => $request->email,
                    'type' => 1,
                    'is_default' => 1
                ]);
            }

            if ($request->mobile_no) {
                $user->contacts()->create([
                    'title' => $request->mobile_no,
                    'type' => 2,
                    'is_default' => 1
                ]);
            }
            AccountService::sendVerificationCode($user);
            AccountService::sendWelcomeMessage($user);

            $request2 = new Request($request->only('username') + [
                    'password' => $request->raw_password
                ]);

            $token = AuthService::generateAuthToken($request2);

            if (empty($token)) {
                return $this->errorResponse('Something went wrong. Token not generated');
            }

            if (property_exists($token, 'error')) {
                return $this->errorResponse('Token generation failure.');
            }

            if (!in_array($user->user_type['id'], [2, 3])) {
                $obj = new LoginController();
                $obj->logout();

                abort(401, 'You are not allowed to login');
            }

            $token->user = $user;

            DB::commit();
            return $this->successResponse('Registration success. An activation code sent to your account.', $token);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function sendResetPasswordCode(Request $request): JsonResponse
    {
        $this->validate($request, [
            'username' => 'required'
        ]);

        $regMedium = AccountService::isEmailOrMobile($request->username);
        if ($regMedium == StaticValueService::regMediumId('mobile')) {
            $request['username'] = AccountService::getFormattedPhoneNo($request->username);
        }

        $user = User::where('username', $request->username)->firstOrFail();

        try {
            $user->account_verification_token = AccountService::generateVerificationToken();
            $user->save();

            AccountService::sendPasswordResetCode($user->username, $user->account_verification_token, $user->reg_medium, $user);

            return $this->successResponse('Password reset code sent successfully.', $user);

        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function verifyResetPasswordCode(Request $request): JsonResponse
    {
        $this->validate($request, [
            'code' => 'required',
            'username' => 'required',
        ]);

        $user = User::where('username', $request->username)->where('account_verification_token', $request->code)->first();

        if (empty($user)) {
            return $this->errorResponse('The code you entered is incorrect');
        }

        return $this->successResponse('');
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            'code' => 'required'
        ]);

        $user = User::where('account_verification_token', $request->code)->firstOrFail();

        try {
            $user->fill([
                'password' => Hash::make($request->password),
                'account_verification_token' => null,
            ]);
            $user->save();

            return $this->successResponse('Password reset successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }


}
