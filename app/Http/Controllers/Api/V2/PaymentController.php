<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V2;

use App\Components\Payment\AwesomePayment\AwesomePayment;
use App\Components\Payment\PaymentSystemMerchant\ScaryPayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V2\Payment\PaymentRequest;
use App\Services\Payment\PaymentServiceInterface;
use App\Services\PaymentAuth\AuthInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentServiceInterface $paymentService,
        protected AuthInterface $paymentAuth
    )
    {
    }
    /**
     * @param PaymentRequest $request
     * @return JsonResponse
     */
    public function process(PaymentRequest $request): JsonResponse
    {
        if (!$this->auth($request, $this->paymentAuth)) {
            return response()->json('Request not authorized', Response::HTTP_UNAUTHORIZED);
        }

        try {
            $payment = match ($request->getContentTypeFormat()) {
                'form' => $this->paymentService->process(new ScaryPayment($request->all())),
                'json' => $this->paymentService->process(new AwesomePayment($request->all())),
            };

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
     * @param AuthInterface $paymentAuth
     * @return bool
     */
    private function auth(Request $request, AuthInterface $paymentAuth): bool
    {
        return $paymentAuth->auth($request);
    }
}
