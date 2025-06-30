<?php

namespace App\Http\Requests\API\Borrow;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Borrow;

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
        return [
            'status' => 'required|in:' . Borrow::STATUS_BORROWED . ',' . Borrow::STATUS_RETURNED,
            'returned_at' => 'nullable|date'
        ];
    }
}
