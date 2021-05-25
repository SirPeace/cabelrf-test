<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'age' => 'required|integer|between:14,120',
            'sex' => ['required', 'string', Rule::in(['F', 'M'])],
            'role_id' => 'required|integer|exists:\App\Models\Role,id'
        ];
    }
}
