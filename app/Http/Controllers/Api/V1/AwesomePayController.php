<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Components\Payment\AwesomePayment\AwesomePayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Payment\AwesomePaymentRequest;
use App\Services\Payment\PaymentServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AwesomePayController extends Controller
{
    /**
     * @param AwesomePaymentRequest $request
     * @param PaymentServiceInterface $paymentService
     * @return JsonResponse
     */
    public function process(AwesomePaymentRequest $request, PaymentServiceInterface $paymentService): JsonResponse
    {
        if (!$this->auth($request)) {
            return response()->json('Request not authorized', Response::HTTP_UNAUTHORIZED);
        }

        try {
            $awesomePayment = new AwesomePayment($request->all());
            $payment = $paymentService->process($awesomePayment);

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
        $data = $request->except('sign');
        ksort($data);
        $implodedData = implode(':', $data) . config('awesomepay.merchant_key');
        $hashData = \hash('sha256', $implodedData);

        return $hashData === $request->get('sign');
    }
}

