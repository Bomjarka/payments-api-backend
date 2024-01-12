<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Components\Payment\PaymentInterface;
use App\Models\Payment;

class PaymentService implements PaymentServiceInterface
{

    /**
     * @param PaymentInterface $paymentFromPaymentSystem
     * @return Payment
     */
    public function process(PaymentInterface $paymentFromPaymentSystem): Payment
    {
        /** @var Payment $payment */
        $payment = Payment::whereExternalPaymentId($paymentFromPaymentSystem->getExternalExternalPaymentId())->first();
        if ($payment) {
            $payment->status = $paymentFromPaymentSystem->getStatus();
        } else {
            $payment = new Payment();
        }

        $payment->payment_system_id = $paymentFromPaymentSystem->getPaymentSystem()->id;
        $payment->external_payment_id = $paymentFromPaymentSystem->getExternalExternalPaymentId();
        $payment->user_id = $paymentFromPaymentSystem->getUser()->id;
        $payment->status = $paymentFromPaymentSystem->getStatus();
        $payment->amount = $paymentFromPaymentSystem->getAmount();
        $payment->amount_paid = $paymentFromPaymentSystem->getAmountPaid();
        $payment->data = $paymentFromPaymentSystem->getData();

        $payment->save();

        return $payment;
    }
}
