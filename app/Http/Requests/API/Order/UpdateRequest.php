<?php

namespace App\Http\Requests\API\Order;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Order;

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
        $statuses = implode(',', [
            Order::STATUS_PENDING,
            Order::STATUS_APPROVED,
            Order::STATUS_REJECTED,
            Order::STATUS_DELIVERED,
        ]);

        return [
            'status' => 'required|in:' . $statuses,
        ];
    }
}
