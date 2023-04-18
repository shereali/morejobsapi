<?php

namespace App\Http\Requests;

class DegreeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'mode' => 'sometimes|required|in:add,edit',
            'id' => 'exclude_unless:mode,edit|required',
        ];
    }
}
