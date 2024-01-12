<?php

namespace App\Services\Payment;

use App\Components\Payment\PaymentInterface;

interface PaymentServiceInterface
{
    public function process(PaymentInterface $paymentFromPaymentSystem);
}
