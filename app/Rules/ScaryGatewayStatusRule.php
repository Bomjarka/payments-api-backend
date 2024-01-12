<?php

declare(strict_types=1);

namespace App\Rules;

use App\Components\Payment\PaymentSystemMerchant\ScaryPayment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ScaryGatewayStatusRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (array_key_exists($value, ScaryPayment::STATUSES) === false) {
            $fail('Unknown status: ' . $value);
        }
    }
}
