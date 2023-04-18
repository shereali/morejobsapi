<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Services\FileHandleService;
use App\Services\HelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function userInfo()
    {
        return Auth::user();
    }

    public function authUser()
    {
        $data = Auth::user()->load('contactEmails');

        return $this->response($data, 'Auth user with related data');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:6|different:current_password',
        ]);

        $user = Auth::user();

        try {
            $result = AccountService::isRightPassword($user, $request->current_password);
            if (!$result) {
                return $this->errorResponse('You entered wrong password!');
            }

            $user->fill([
                'password' => Hash::make($request->password),
            ]);
            $user->save();

            return $this->successResponse('Password changed successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function uploadAvatar(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image',
        ]);

        $user = Auth::user();

        try {
            if ($request->hasFile('file')) {
                $path = FileHandleService::upload($request->file, FileHandleService::getAvatarStoragePath());

                if ($user->image) {
                    FileHandleService::delete($user->getOriginal('image'));
                }

                $user->image = $path;
                $user->save();

                return $this->successResponse('Image uploaded successfully', $user);
            }
            return $this->errorResponse('Image upload failure. File not found!');

        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function destroyAvatar()
    {
        $user = Auth::user();

        if ($user->image) {
            try {
                FileHandleService::delete($user->getOriginal('image'));

                return $this->successResponse('Image deleted successfully');

            } catch (\Exception $e) {
                return $this->errorResponse();
            }
        }

        return $this->errorResponse('This user has no image to delete');
    }

    public function updateUserId(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ]);

        $user = Auth::user();

        try {
            $result = AccountService::isRightPassword($user, $request->password);
            if (!$result) {
                return $this->errorResponse('You entered wrong password!');
            }

            $username = $request->username;
            if (AccountService::isEmailOrMobile($request->username) == 4){
                $username =  AccountService::getFormattedPhoneNo($username);
            }

            $user->username = $username;
            $user->save();

            return $this->successResponse('Your user ID changed successfully');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }
}
