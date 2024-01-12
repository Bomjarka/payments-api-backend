<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V2\Payment;

use App\Rules\PaymentSystemRule;
use App\Rules\ScaryGatewayStatusRule;

class ScaryPaymentRequest extends PaymentRequest
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
            'project' => ['required', 'integer', new PaymentSystemRule()],
            'invoice' => 'required|integer',
            'status' => ['required', 'string', new ScaryGatewayStatusRule()],
            'amount' => 'required|integer|min:1',
            'amount_paid' => 'required|integer|min:1',
            'rand' => 'required|string',
        ];
    }
}
