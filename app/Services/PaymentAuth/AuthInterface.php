<?php

namespace App\Services\PaymentAuth;

use App\Http\Requests\Api\V2\Payment\PaymentRequest;

interface AuthInterface
{
    public function auth(PaymentRequest $request): bool;
}
