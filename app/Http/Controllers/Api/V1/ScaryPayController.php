<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Components\Payment\PaymentSystemMerchant\ScaryPayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Payment\ScaryPaymentRequest;
use App\Services\Payment\PaymentServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScaryPayController extends Controller
{
    /**
     * @param ScaryPaymentRequest $request
     * @param PaymentServiceInterface $paymentService
     * @return JsonResponse
     */
    public function process(ScaryPaymentRequest $request, PaymentServiceInterface $paymentService): JsonResponse
    {
        if (!$this->auth($request)) {
            return response()->json('Request not authorized', Response::HTTP_UNAUTHORIZED);
        }

        try {
            $scaryPayment = new ScaryPayment($request->all());
            $payment = $paymentService->process($scaryPayment);

            return response()->json($payment);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function auth(Request $request): bool
    {
        $data = $request->all();
        ksort($data);
        $implodedData = implode('.', $data) . config('scarypay.merchant_key');
        $hashData = \hash('md5', $implodedData);

        return $hashData === $request->header('authorization');
    }
}

