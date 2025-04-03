<?php

namespace App\Http\Requests\Admin;

use App\Enums\PostStatusEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => [
                'required',
                'max:255',
            ],

            'slug' => [
                'required',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'max:255',
            ],

            'summary' => [
                'sometimes',
                'max:255',
            ],

            'content' => [
                'required',
            ],

            'status' => [
                'required',
                Rule::in(PostStatusEnum::getValues())
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'featured_image' => [
                'nullable',
                'sometimes',
                'url',
            ],
        ];
    }
}
