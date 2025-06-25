<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'books' => 'required|array',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'books.required' => 'قائمة الكتب مطلوبة.',
            'books.array' => 'قائمة الكتب يجب أن تكون مصفوفة.',
            'books.*.book_id.required' => 'معرف الكتاب مطلوب لكل عنصر.',
            'books.*.book_id.exists' => 'أحد الكتب المحددة غير موجود.',
            'books.*.quantity.required' => 'كمية الكتاب مطلوبة لكل عنصر.',
            'books.*.quantity.integer' => 'كمية الكتاب يجب أن تكون رقمًا صحيحًا.',
            'books.*.quantity.min' => 'أقل كمية للكتاب هي 1.',
        ];
    }
} 