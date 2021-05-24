<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:10',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric',
            'status_id' => 'required|integer|exists:\App\Models\ProductStatus,id',
            'available_count' => 'required|integer',
        ];
    }
}
