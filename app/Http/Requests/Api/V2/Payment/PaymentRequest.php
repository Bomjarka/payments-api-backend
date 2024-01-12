<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V2\Payment;

use App\Http\Requests\FormRequest;

abstract class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    abstract public function authorize(): bool;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    abstract public function rules(): array;
}
