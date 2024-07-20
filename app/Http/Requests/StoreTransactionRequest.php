<?php

namespace App\Http\Requests;

use App\Enum\PaymentStatus;
use App\Enum\TransactionStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'invoice_number' => ['nullable', Rule::unique('transactions', 'invoice_number')],
            'start_date' => ['required', 'date'],
            'target_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'payment_date' => ['nullable', 'date'],
            'customer_id' => ['required'],
            'status' => ['required', Rule::in(TransactionStatus::cases())],
            'payment' => ['required', Rule::in(PaymentStatus::cases())],
            'note' => ['nullable'],
            'user_id' => ['nullable'],
            'subtotal' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'tax' => ['required', 'numeric'],
            'additional_fee' => ['required', 'numeric'],
            'grand_total' => ['required', 'numeric'],
            'discount_percentage' => ['required', 'numeric'],
            'tax_percentage' => ['required', 'numeric'],
        ];
    }

    public function attributes(): array
    {
        return [
            'start_date' => 'date',
            'target_date' => 'estimated completion date',
            'customer_id' => 'customer',
        ];
    }
}
