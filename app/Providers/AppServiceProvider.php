<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Requests\Api\V2\Payment\AwesomePaymentRequest;
use App\Http\Requests\Api\V2\Payment\PaymentRequest;
use App\Http\Requests\Api\V2\Payment\ScaryPaymentRequest;
use App\Services\Payment\PaymentService;
use App\Services\Payment\PaymentServiceInterface;
use App\Services\PaymentAuth\AuthInterface;
use App\Services\PaymentAuth\AwesomePaymentAuth;
use App\Services\PaymentAuth\ScaryPaymentAuth;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $paymentV2RateLimiter = new RateLimiter();

        $this->app->bind(PaymentServiceInterface::class, PaymentService::class);

        if (str_contains(request()->getRequestUri(), 'api/v1/payment')
            || str_contains(request()->getRequestUri(), 'api/v2/payment')
        ) {
            switch (request()->getContentTypeFormat()):
                case 'json':
                    $this->app->bind(PaymentRequest::class, AwesomePaymentRequest::class);
                    $this->app->bind(AuthInterface::class, AwesomePaymentAuth::class);
                    $paymentV2RateLimiter::for('payment', function () {
                        return Limit::perDay(config('awesomepay.limit'));
                    });
                    break;
                case 'form':
                    $this->app->bind(PaymentRequest::class, ScaryPaymentRequest::class);
                    $this->app->bind(AuthInterface::class, ScaryPaymentAuth::class);
                    $paymentV2RateLimiter::for('payment', function () {
                        return Limit::perDay(config('scarypay.limit'));
                    });
                    break;
                default:
                    throw new \Exception('Unsupported content type: ' . request()->getContentTypeFormat());
            endswitch;
        }
    }
}
