<?php

namespace App\Http\Controllers\Admin;

use App\Events\AuthEvent;
use App\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\AccountService;
use App\Services\HelperService;
use App\Services\StaticValueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(UserFilters $filters): JsonResponse
    {
        $data = User::filter($filters)
            ->where('user_type', '!=', StaticValueService::userTypeIdByKey('super_admin'))
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit(20));

        return $this->response($data, 'User list');
    }

    public function show($id): JsonResponse
    {
        $data = User::with('defaultContact', 'contacts', 'profile', 'gender', 'religion', 'maritalStatus', 'country')
            ->findOrFail($id);

        return $this->response($data, 'User details');
    }

    public function store(UserRequest $request)
    {
        $request->merge([
            'reg_medium' => AccountService::isEmailOrMobile($request['username']),
            'status' => 1,
            'user_type' => StaticValueService::userTypeIdByKey('admin'),
        ]);

        try {
            DB::beginTransaction();

            if ($request->input('mode') == 'edit') {
                $user = User::findOrFail($request->input('id'));

                $user->fill($request->only('first_name', 'last_name', 'username'));
                if ($request->input('password')) {
                    $user['password'] = Hash::make($request->input('password'));
                }
                $user->save();

                $message = 'User updated successfully';
            } else {
                $user = event(new AuthEvent($request->all(), true))[0];

                $message = 'User created successfully';
            }

            DB::commit();
            return $this->successResponse($message, $user);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1,2'
        ]);

        $user = User::findOrFail($id);

        try {
            $user->fill($request->only('status'));
            $user->save();

            return $this->successResponse('User status changed successfully', $user);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }
}
