<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'image' => ['sometimes', 'image', 'max:1050', 'mimes:jpg,jpeg,png'],
            'description' => ['sometimes', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
