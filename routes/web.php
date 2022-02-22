<?php

use Illuminate\Support\Facades\Route;

if (config('APP_ENV',env('APP_ENV')) === 'production') {
    \Illuminate\Support\Facades\URL::forceScheme('https');
}

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home','StripePaymentController@index');

Route::get('stripe/payments','StripePaymentController@index');

Route::get('stripe/payment/status','StripePaymentController@success')->name('stripe.success');

Route::post('stripe/payment/indent','StripePaymentController@createPaymentIndent')->name('stripe.payment.indent');

Route::post('stripe/webhook/response','StripePaymentController@webhookResponse')->name('stripe.payment.webhook.response');

