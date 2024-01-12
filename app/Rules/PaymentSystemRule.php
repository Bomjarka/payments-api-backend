<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\PaymentSystem;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PaymentSystemRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = PaymentSystem::find($value);
        if (!$paymentSystem) {
            $fail('Unknown payment system: ' . $value);
        }

        if ($paymentSystem->id !== PaymentSystem::PAYMENT_SYSTEMS[$paymentSystem->name]) {
            $fail('Wrong payment system id: ' . $value);
        }
    }
}
