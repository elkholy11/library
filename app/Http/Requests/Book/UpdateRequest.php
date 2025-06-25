<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $bookId = $this->route('book')->id;

        return [
            'title' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('books')->ignore($bookId)],
            'description' => 'nullable|string',
            'description_en' => 'nullable|string',
            'isbn' => ['nullable', 'string', 'max:255', Rule::unique('books', 'isbn')->ignore($bookId)],
            'publisher' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'pages' => 'nullable|integer|min:1',
            'language' => 'required|in:ar,en',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'slug.unique' => 'الرابط المختصر مستخدم بالفعل',
            'isbn.unique' => 'رقم ISBN مستخدم بالفعل',
            'quantity.min' => 'الكمية يجب أن تكون 1 على الأقل',
            'category_id.exists' => 'التصنيف غير موجود',
            'author_id.exists' => 'المؤلف غير موجود',
            'cover_image.image' => 'يجب أن يكون غلاف الكتاب صورة.',
            'cover_image.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميجا بايت.',
        ];
    }
} 