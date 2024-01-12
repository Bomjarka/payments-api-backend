<?php

use App\Http\Controllers\Api\V1\AwesomePayController;
use App\Http\Controllers\Api\V1\ScaryPayController;
use App\Http\Controllers\Api\V2\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/v1/payment'], static function () {
    Route::post('/awesomepay', [AwesomePayController::class, 'process'])
        ->middleware(['throttle:awesomepay'])
        ->name('api.v1.payment.awesomepay.process');
    Route::post('/scarypay', [ScaryPayController::class, 'process'])
        ->middleware(['throttle:scarypay'])
        ->name('api.v1.payment.scarypay.process');
});

Route::group(['prefix' => '/v2/payment'], static function () {
    Route::post('/', [PaymentController::class, 'process'])
        ->middleware(['throttle:payment'])
        ->name('api.v2.payment.process');
});
