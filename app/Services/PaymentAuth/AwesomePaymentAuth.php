<?php

declare(strict_types=1);

namespace App\Services\PaymentAuth;

use App\Http\Requests\Api\V2\Payment\PaymentRequest;

class AwesomePaymentAuth implements AuthInterface
{

    /**
     * @param PaymentRequest $request
     * @return bool
     */
    public function auth(PaymentRequest $request): bool
    {
        $data = $request->except('sign');
        ksort($data);
        $implodedData = implode(':', $data) . config('awesomepay.merchant_key');
        $hashData = \hash('sha256', $implodedData);

        return $hashData === $request->get('sign');
    }
}
