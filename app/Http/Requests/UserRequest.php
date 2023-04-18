<?php

namespace App\Http\Requests;

class UserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $request = app('request');

        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'mode' => 'sometimes|required|in:add,edit',
            'id' => 'exclude_unless:mode,edit|required',
        ];

        if ($request->mode == 'edit') {
            $rules['username'] = 'string|unique:users,username,' . $request->id;
            unset($rules['password']);
        }

        return $rules;
    }
}
