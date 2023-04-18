<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mode' => 'sometimes|required|string|in:add,edit',
            'id' => 'exclude_unless:mode,edit|required|integer',
            'category_id' => 'required|integer|'.Rule::exists('categories', 'id'),
            'title' => 'required|string',
        ];
    }
}
