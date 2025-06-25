<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class DashboardStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization is handled by the 'is_admin' middleware on the route.
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
            'user_id' => 'required|exists:users,id',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'حقل المستخدم مطلوب.',
            'user_id.exists' => 'المستخدم المحدد غير موجود.',
            'books.required' => 'قائمة الكتب مطلوبة.',
            'books.*.book_id.required' => 'معرف الكتاب مطلوب لكل عنصر.',
            'books.*.book_id.exists' => 'أحد الكتب المحددة غير موجود.',
            'books.*.quantity.required' => 'كمية الكتاب مطلوبة لكل عنصر.',
            'books.*.quantity.min' => 'أقل كمية للكتاب هي 1.',
        ];
    }
} 