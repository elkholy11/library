<?php

namespace App\Http\Requests\Borrow;

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
            'returned_at' => 'nullable|date',
            'status' => 'required|in:borrowed,returned',
        ];
    }

    public function messages(): array
    {
        return [
            'returned_at.date' => __('تاريخ الإرجاع غير صحيح'),
            'status.required' => __('حالة الإعارة مطلوبة'),
            'status.in' => __('حالة الإعارة غير صحيحة'),
        ];
    }
} 