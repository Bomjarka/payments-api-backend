<?php

declare(strict_types=1);

namespace App\Components\Payment;

interface PaymentInterface
{
    public function getMerchantId();
    public function getExternalExternalPaymentId();
    public function getUserId();
    public function getUser();
    public function getStatus();
    public function getAmount();
    public function getAmountPaid();
    public function getPaidAt();
    public function getData();
}
