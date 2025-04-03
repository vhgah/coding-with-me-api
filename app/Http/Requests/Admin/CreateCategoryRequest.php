<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
            ],

            'slug' => [
                'required',
                'regex:/^\/$|^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'max:255',
            ],

            'position' => [
                'required',
                'integer',
            ],
        ];
    }
}
