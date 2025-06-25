<?php

namespace App\Http\Requests\BookRequest;

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
            'user_id' => 'sometimes|exists:users,id',
            'book_title' => 'sometimes|required|string|max:255',
            'author_name' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => __('حالة الطلب مطلوبة'),
            'status.in' => __('حالة الطلب غير صحيحة'),
        ];
    }
}

 