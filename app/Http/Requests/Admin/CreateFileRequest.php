<?php

namespace App\Http\Requests\Admin;

use App\Enums\FileTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateFileRequest extends FormRequest
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
            'file' => [
                'required',
                'file',
                'mimes:jpeg,png,pdf,docx,doc,xlsx,xls,webp',
                'max:2048',
            ],
            'type' => [
                'required',
                Rule::in(FileTypeEnum::getValues()),
            ]
        ];
    }
}
