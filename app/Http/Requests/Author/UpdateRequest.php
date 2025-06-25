<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'ar_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم بالإنجليزية مطلوب',
            'name.max' => 'الاسم بالإنجليزية يجب ألا يتجاوز 255 حرفًا',
            'ar_name.max' => 'الاسم بالعربية يجب ألا يتجاوز 255 حرفًا',
            'status.required' => 'الحالة مطلوبة',
        ];
    }
} 