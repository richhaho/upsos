<?php

use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\ServiceCheckout\PaypalController;
use App\Http\Controllers\ServiceCheckout\StripeController;
use App\Http\Controllers\ServiceCheckout\FlutterwaveController;
use App\Http\Controllers\ServiceCheckout\AuthorizeController;
use App\Http\Controllers\ServiceCheckout\RazorpayController;
use App\Http\Controllers\ServiceCheckout\PaystackController;
use App\Http\Controllers\ServiceCheckout\PaytmController;
use App\Http\Controllers\ServiceCheckout\InstamojoController;
use App\Http\Controllers\ServiceCheckout\ManualController;
use App\Http\Controllers\ServiceCheckout\MercadopagoController;

use Illuminate\Support\Facades\Route;

Route::get('/service/checkout/{slug}', [CheckoutController::class,'checkout'])->name('checkout.index');
Route::get('/getarealist/{id}', [CheckoutController::class,'getAreaList'])->name('city.getAreaList');
Route::get('/getschedule/{id}/{id2}', [CheckoutController::class,'getSchedule'])->name('service.getSchedule');


// Payment Gateway Route Start

// Paypal Route
Route::post('service/paypal/submit', [PaypalController::class,'store'])->name('service.paypal.submit');
Route::get('service/paypal/notify', [PaypalController::class,'notify'])->name('service.paypal.notify');
Route::get('service/paypal/cancle', [PaypalController::class,'cancel'])->name('service.paypal.cancel');

// Stripe Route
//Route::post('service/stripe/submit', [StripeController::class,'store'])->name('service.stripe.submit');
Route::post('service/stripe/create', [StripeController::class,'create'])->name('service.stripe.create');
Route::get('service/stripe/success', [StripeController::class,'success'])->name('service.stripe.success');

// FLutterwave Route
Route::post('service/flutter/submit', [FlutterwaveController::class,'store'])->name('service.flutter.submit');
Route::post('service/flutter/notify', [FlutterwaveController::class,'notify'])->name('service.flutter.notify');

// Authorize.net Route
Route::post('service/authorize/submit', [AuthorizeController::class,'store'])->name('service.authorize.submit');

// Razorpay Route
Route::post('service/razorpay/submit', [RazorpayController::class,'store'])->name('service.razorpay.submit');
Route::post('service/razorpay/notify', [RazorpayController::class,'notify'])->name('service.razorpay.notify');

// Paytm Route
Route::post('service/paytm/submit', [PaytmController::class,'store'])->name('service.paytm.submit');
Route::post('service/paytm/callback', [PaytmController::class,'paytmCallback'])->name('service.paytm.notify');

// Instamojo Route
Route::post('service/instamojo/submit', [InstamojoController::class,'store'])->name('service.instamojo.submit');
Route::get('service/instamojo/callback', [InstamojoController::class,'notify'])->name('service.instamojo.notify');
Route::get('service/instamojo/cancle', [InstamojoController::class,'cancel'])->name('service.instamojo.cancel');

// Paystack Route
Route::post('service/paystack/submit', [PaystackController::class,'store'])->name('service.paystack.submit');

// MercadoPago Route
Route::post('service/mercadopago-submit', [MercadopagoController::class,'store'])->name('service.mercadopago.submit');

// Manual Route
Route::post('service/manual-submit', [ManualController::class,'store'])->name('service.manual.submit');

Route::get('service/checkout/payment/{slug1}/{slug2}',[CheckoutController::class,'loadpayment'])->name('service.load.payment');
