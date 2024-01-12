<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V2\Payment;

use App\Rules\AwesomeGatewayStatusRule;
use App\Rules\PaymentSystemRule;

class AwesomePaymentRequest extends PaymentRequest
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
            'merchant_id' => ['required', 'integer', new PaymentSystemRule()],
            'payment_id' => 'required|integer',
            'status' => ['required', 'string', new AwesomeGatewayStatusRule()],
            'amount' => 'required|integer|min:1',
            'amount_paid' => 'required|integer|min:1',
            'timestamp' => 'required|integer',
            'sign' => 'required|string',
        ];
    }
}
