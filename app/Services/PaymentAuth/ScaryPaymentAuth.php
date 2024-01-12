<?php

namespace App\Services\PaymentAuth;

use App\Http\Requests\Api\V2\Payment\PaymentRequest;

class ScaryPaymentAuth implements AuthInterface
{

    /**
     * @param PaymentRequest $request
     * @return bool
     */
    public function auth(PaymentRequest $request): bool
    {
        $data = $request->all();
        ksort($data);
        $implodedData = implode('.', $data) . config('scarypay.merchant_key');
        $hashData = \hash('md5', $implodedData);

        return $hashData === $request->header('authorization');
    }
}
