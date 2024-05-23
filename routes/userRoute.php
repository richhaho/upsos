<?php
use App\Http\Controllers;

use App\Http\Controllers\Deposit\AuthorizeController;
use App\Http\Controllers\Deposit\BlockIoController;
use App\Http\Controllers\Deposit\CoinpaymentController;
use App\Http\Controllers\Deposit\InstamojoController;
use App\Http\Controllers\Deposit\MollieController;
use App\Http\Controllers\Deposit\PaypalController;
use App\Http\Controllers\Deposit\PaytmController;
use App\Http\Controllers\Deposit\RazorpayController;
use App\Http\Controllers\Deposit\StripeController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\Deposit\FlutterwaveController;
use App\Http\Controllers\Deposit\ManualController;
use App\Http\Controllers\Deposit\MercadopagoController;
use App\Http\Controllers\Deposit\PayeerController;
use App\Http\Controllers\Deposit\PaystackController;
use App\Http\Controllers\Deposit\PerfectMoneyController;
use App\Http\Controllers\Deposit\SkrillController;
use App\Http\Controllers\JobConversationController;
use App\Http\Controllers\ServiceConversationController;
use App\Http\Controllers\User\ApplyjobController;
use App\Http\Controllers\User\ForgotController;
use App\Http\Controllers\User\KYCController;
use App\Http\Controllers\User\MessageController;

use App\Http\Controllers\User\OTPController;
use App\Http\Controllers\User\PricingPlanController;

use App\Http\Controllers\User\RegisterController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WithdrawController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController as AppDashboardController;

use App\Http\Controllers\User\JobOrderController;
use App\Http\Controllers\User\LoginController as UserLoginController;
use App\Http\Controllers\User\ScheduleController;
use App\Http\Controllers\User\ServiceAttributeController;
use App\Http\Controllers\User\ServiceController;
use App\Http\Controllers\User\ServiceOrderController;
use App\Http\Controllers\User\SubscriptionController;
use App\Http\Controllers\User\TransferController;

Route::prefix('user')->group(function() {

    Route::get('/login', [UserLoginController::class,'showLoginForm'])->name('user.login');
    Route::post('/login', [UserLoginController::class,'login'])->name('user.login.submit');

    Route::get('/forgot', [ForgotController::class,'showforgotform'])->name('user.forgot');
    Route::post('/forgot', [ForgotController::class,'forgot'])->name('user.forgot.submit');

    Route::get('/otp', [OTPController::class,'showotpForm'])->name('user.otp');
    Route::post('/otp', [OTPController::class,'otp'])->name('user.otp.submit');

    Route::get('/register', [RegisterController::class,'showRegisterForm'])->name('user.register');
    Route::post('/register', [RegisterController::class,'register'])->name('user.register.submit');
    Route::get('/register/verify/{token}', [RegisterController::class,'token'])->name('user.register.token');

    Route::group(['middleware' => ['otp','banuser','seller']],function () {

      Route::get('/dashboard', [UserController::class,'index'])->name('user.dashboard');
      Route::get('/username/{number}', [UserController::class,'username'])->name('user.username');
      Route::get('/transactions', [UserController::class,'transaction'])->name('user.transaction');
      Route::get('/has-unread-messages', [UserController::class,'hasUnreadMessages'])->name('user.hasUnreadMessages');

      Route::get('/2fa-security', [UserController::class,'showTwoFactorForm'])->name('user.show2faForm');
      Route::post('/createTwoFactor', [UserController::class,'createTwoFactor'])->name('user.createTwoFactor');
      Route::post('/disableTwoFactor', [UserController::class,'disableTwoFactor'])->name('user.disableTwoFactor');

      Route::get('/profile', [UserController::class,'profile'])->name('user.profile.index');
      Route::post('/profile', [UserController::class,'profileupdate'])->name('user.profile.update');

      Route::get('/kyc-form', [KYCController::class,'kycform'])->name('user.kyc.form');
      Route::post('/kyc-form', [KYCController::class,'kyc'])->name('user.kyc.submit');


      Route::group(['middleware'=>'kyc:Service'],function(){
       
        Route::get('service', [ServiceController::class,'index'])->name('user.service');
        Route::get('add/service', [ServiceController::class,'addService'])->name('user.add.service');
        Route::post('add/service', [ServiceController::class,'storeService'])->name('user.store.service');
        Route::get('edit/service/{id}', [ServiceController::class,'editService'])->name('user.edit.service');
        Route::post('edit/service/{id}', [ServiceController::class,'updateService'])->name('user.update.service');
        Route::get('delete/service/{id}', [ServiceController::class,'deleteService'])->name('user.delete.service');

        // Attribute Route start from here 
        Route::get('add/attributes/{slug}', [ServiceAttributeController::class,'attribute'])->name('user.attribute');
        Route::post('add/attributes/{id}', [ServiceAttributeController::class,'storeAttribute'])->name('user.store.attribute');
        Route::get('edit/attributes/{slug}', [ServiceAttributeController::class,'editAttribute'])->name('user.edit.attribute');
        Route::post('edit/attributes/{id}', [ServiceAttributeController::class,'updateAttribute'])->name('user.update.attribute');
        // Schedule Route start from here
        Route::get('add/schedule',[ScheduleController::class,'addSchedule'])->name('user.add.schedule');
        Route::post('add/schedule',[ScheduleController::class,'storeSchedule'])->name('user.store.schedule');

        Route::post('edit/schedule/{id}',[ScheduleController::class,'updateSchedule'])->name('user.update.schedule');
        Route::get('delete/schedule/{id}',[ScheduleController::class,'deleteSchedule'])->name('user.delete.schedule');
        
      });

      Route::group(['middleware'=>'kyc:Payouts'],function(){
        Route::get('/payout', [WithdrawController::class,'index'])->name('user.withdraw.index');
        Route::post('/payout/request', [WithdrawController::class,'store'])->name('user.withdraw.request');
        Route::get('/payouts/history', [WithdrawController::class,'history'])->name('user.withdraw.history');
        Route::get('/payout/{id}', [WithdrawController::class,'details'])->name('user.withdraw.details');
      });

      Route::group(['middleware'=>'kyc:Deposits'],function(){
        Route::get('/deposits',[DepositController::class,'index'])->name('user.deposit.index');
        Route::get('/deposit/create',[DepositController::class,'create'])->name('user.deposit.create');
      });

      Route::get('/package',[PricingPlanController::class,'index'])->name('user.package.index');
      Route::get('/package/subscription/{id}',[PricingPlanController::class,'subscription'])->name('user.package.subscription');

      Route::post('/deposit/stripe-submit', [StripeController::class,'store'])->name('user.deposit.stripe.submit');

      Route::post('/deposit/mercadopago-submit', [MercadopagoController::class,'store'])->name('deposit.mercadopago.submit');

      Route::post('/deposit/paystack/submit', [PaystackController::class,'store'])->name('deposit.paystack.submit');

      Route::post('/paypal-submit', [PaypalController::class,'store'])->name('user.deposit.paypal.submit');
      Route::get('/paypal/deposit/notify', [PaypalController::class,'notify'])->name('user.deposit.paypal.notify');
      Route::get('/paypal/deposit/cancle', [PaypalController::class,'cancel'])->name('user.deposit.paypal.cancel');

      Route::post('/deposit/skrill-submit', [SkrillController::class,'store'])->name('user.deposit.skrill.submit');
      Route::any('/deposit/skrill-notify', [SkrillController::class,'notify'])->name('user.deposit.skrill.notify');

      Route::post('/deposit/perfectmoney-submit', [PerfectMoneyController::class,'store'])->name('deposit.perfectmoney.submit');
      Route::any('/deposit/perfectmoney-notify', [PerfectMoneyController::class,'notify'])->name('deposit.perfectmoney.notify');

      Route::post('/deposit/payeer-submit', [PayeerController::class,'store'])->name('user.deposit.payeer.submit');
      Route::any('/deposit/payeer-notify', [PayeerController::class,'notify'])->name('user.deposit.payeer.notify');

      Route::post('/instamojo-submit',[InstamojoController::class,'store'])->name('user.deposit.instamojo.submit');
      Route::get('/instamojo-notify',[InstamojoController::class,'notify'])->name('user.deposit.instamojo.notify');

      Route::post('/deposit/paytm-submit', [PaytmController::class,'store'])->name('user.deposit.paytm.submit');
      Route::post('/deposit/paytm-callback', [PaytmController::class,'paytmCallback'])->name('user.deposit.paytm.notify');

      Route::post('/deposit/razorpay-submit', [RazorpayController::class,'store'])->name('user.deposit.razorpay.submit');
      Route::post('/deposit/razorpay-notify', [RazorpayController::class,'notify'])->name('user.deposit.razorpay.notify');

      Route::post('/deposit/molly-submit', [MollieController::class,'store'])->name('deposit.molly.submit');
      Route::get('/deposit/molly-notify', [MollieController::class,'notify'])->name('deposit.molly.notify');

      Route::post('/deposit/flutter/submit', [FlutterwaveController::class,'store'])->name('user.deposit.flutter.submit');
      Route::post('/deposit/flutter/notify', [FlutterwaveController::class,'notify'])->name('user.deposit.flutter.notify');

      Route::post('/authorize-submit', [AuthorizeController::class,'store'])->name('user.deposit.authorize.submit');
      Route::post('/deposit/manual-submit', [ManualController::class,'store'])->name('user.deposit.manual.submit');

      Route::post('/deposit/coinpayment-submit', [CoinpaymentController::class,'deposit'])->name('deposit.coinpay.submit');
      Route::post('/deposit/coinpayment/notify', [CoinpaymentController::class,'coincallback'])->name('deposit.coinpay.notify');
      Route::get('/deposit/coinpayment', [CoinpaymentController::class,'blockInvest'])->name('deposit.coinpay.invest');

      Route::post('/deposit/blockio-submit', [BlockIoController::class,'deposit'])->name('deposit.blockio.submit');
      Route::post('/deposit/blockio/notify', [BlockIoController::class,'blockiocallback'])->name('deposit.blockio.notify');
      Route::get('/deposit/blockio', [BlockIoController::class,'blockioDeposit'])->name('blockio.deposit');

      Route::get('/affilate/code', [UserController::class,'affilate_code'])->name('user-affilate-code');


      Route::get('/notf/show', 'User\NotificationController@user_notf_show')->name('customer-notf-show');
      Route::get('/notf/count','User\NotificationController@user_notf_count')->name('customer-notf-count');
      Route::get('/notf/clear','User\NotificationController@user_notf_clear')->name('customer-notf-clear');

      Route::get('support-tickets', [MessageController::class,'index'])->name('user.message.index');
      Route::get('create/support-tickets', [MessageController::class,'create'])->name('user.message.create');
      Route::post('support-tickets/store', [MessageController::class,'store'])->name('user.message.store');
      Route::get('support-tickets/show/{id}', [MessageController::class,'show'])->name('user.message.show');
      Route::post('support-tickets/conversation/{id}', [MessageController::class,'conversation'])->name('user.message.conversation');
      Route::get('admin/message/{id}/delete', [MessageController::class,'adminmessagedelete'])->name('user.message.delete1');

      Route::get('/change-password', [UserController::class,'changePasswordForm'])->name('user.change.password.form');
      Route::post('/change-password', [UserController::class,'changePassword'])->name('user.change.password');


      // This is new route
      Route::get('/subscription/planss',[SubscriptionController::class,'plans'])->name('user.invest.plans');
      Route::get('/subscription/{slug}', [SubscriptionController::class,'userSubscription'])->name('user.subscription');

      Route::post('/apply/job', [ApplyjobController::class,'apply'])->name('user.apply.job');

      Route::get('all/job/request' , [ApplyjobController::class,'alljobrequest'])->name('user.all.job.request');
      
      Route::get('/job/order/',[JobOrderController::class,'index'])->name('user.job.order');
      Route::post('/job/order/{id}',[JobOrderController::class,'store'])->name('user.job.order.store');
      Route::get('job/order/details/{id}',[JobOrderController::class,'details'])->name('user.job.order.details');

      // Job Conversation Controller
      Route::get('job/conversation/{id}',[JobConversationController::class,'index'])->name('user.job.conversation');
      Route::post('job/conversation/{id}',[JobConversationController::class,'store'])->name('user.job.conversation.store');

      Route::group(['middleware'=>'kyc:Service Order'],function(){
      Route::get('/service/order/{slug}',[ServiceOrderController::class,'index'])->name('user.service.order');
      Route::post('/service/order-status/{id}',[ServiceOrderController::class,'status'])->name('user.service.order.status');
      Route::get('/service/order-details/{id}',[ServiceOrderController::class,'details'])->name('user.service.order.details');
      Route::post('/service/order/complete/{id}', [ServiceOrderController::class,'completerequest'])->name('seller.service.order.complete');

      // Service Conversation Route
      Route::get('service/conversation/{id}',[ServiceConversationController::class,'index'])->name('user.service.conversation');
      Route::post('service/conversation/{id}',[ServiceConversationController::class,'store'])->name('user.service.conversation.store');
      });



      
    });

   
    Route::get('/logout', [UserLoginController::class,'logout'])->name('user.logout');

  });
