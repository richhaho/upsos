<?php



use App\Http\Controllers\Buyer\BuyerController;

use App\Http\Controllers\Buyer\DepositController;

use App\Http\Controllers\Buyer\JobController;

use App\Http\Controllers\Buyer\JobOrderController;

use App\Http\Controllers\Buyer\JobRequestController;

use App\Http\Controllers\Buyer\ServiceOrderController;

use App\Http\Controllers\Deposit\AuthorizeController;

use App\Http\Controllers\Deposit\BlockIoController;

use App\Http\Controllers\Deposit\CoinpaymentController;

use App\Http\Controllers\Deposit\FlutterwaveController;

use App\Http\Controllers\Deposit\InstamojoController;

use App\Http\Controllers\Deposit\ManualController;

use App\Http\Controllers\Deposit\MercadopagoController;

use App\Http\Controllers\Deposit\MollieController;

use App\Http\Controllers\Deposit\PayeerController;

use App\Http\Controllers\Deposit\PaypalController;

use App\Http\Controllers\Deposit\PaystackController;

use App\Http\Controllers\Deposit\PaytmController;

use App\Http\Controllers\Deposit\PerfectMoneyController;

use App\Http\Controllers\Deposit\RazorpayController;

use App\Http\Controllers\Deposit\SkrillController;

use App\Http\Controllers\Deposit\StripeController;

use App\Http\Controllers\JobConversationController;

use App\Http\Controllers\JobPayment\WalletController;

use App\Http\Controllers\ServiceConversationController;

use App\Http\Controllers\User\LoginController;

use App\Http\Controllers\User\MessageController;

use App\Http\Controllers\User\UserController;

use App\Http\Controllers\User\WithdrawController;

use Illuminate\Support\Facades\Route;





Route::prefix('buyer')->group(function() {



    Route::group(['middleware' => ['otp','banuser','buyer']],function () {

        Route::get('/dashboard', [BuyerController::class,'index'])->name('buyer.dashboard');

        Route::get('/jobs', [JobController::class,'jobs'])->name('buyer.jobs');



        Route::group(['middleware'=>'kyc:Job'],function(){



        Route::get('/jobs/create', [JobController::class,'jobcreate'])->name('buyer.job.create');

        Route::post('/jobs/store', [JobController::class,'jobstore'])->name('buyer.job.store');

        Route::get('/jobs/edit/{id}', [JobController::class,'jobedit'])->name('buyer.job.edit');

        Route::post('/jobs/update/{id}', [JobController::class,'jobupdate'])->name('buyer.job.update');

        Route::get('/jobs/delete/{id}', [JobController::class,'jobdelete'])->name('buyer.job.delete');



        });



        // Transaction Route

        Route::get('/transactions', [UserController::class,'transaction'])->name('buyer.transaction');



        // All Job Request Route

        Route::get('/jobrequest', [JobRequestController::class,'index'])->name('buyer.jobrequest');

        Route::get('/show/jobrequest/{id}', [JobRequestController::class,'show'])->name('buyer.jobrequest.show');

        Route::get('/jobrequest/delete/{id}', [JobRequestController::class,'delete'])->name('buyer.jobrequest.delete');





        Route::group(['middleware'=>'kyc:Deposits'],function(){

            Route::get('/deposits',[DepositController::class,'index'])->name('buyer.deposit.index');

            Route::get('/deposit/create',[DepositController::class,'create'])->name('buyer.deposit.create');

        });



        // Wallet Subscription Controller

       Route::post('/job/wallet/submit', [WalletController::class,'store'])->name('buyer.wallet.submit');



       Route::get('job/conversation/{id}',[JobConversationController::class,'index'])->name('buyer.job.conversation');

      Route::post('job/conversation/{id}',[JobConversationController::class,'store'])->name('buyer.job.conversation.store');





      Route::group(['middleware'=>'kyc:Payouts'],function(){

        Route::get('/payout', [WithdrawController::class,'index'])->name('buyer.withdraw.index');

        Route::post('/payout/request', [WithdrawController::class,'store'])->name('buyer.withdraw.request');

        Route::get('/payouts/history', [WithdrawController::class,'history'])->name('buyer.withdraw.history');

        Route::get('/payout/{id}', [WithdrawController::class,'details'])->name('buyer.withdraw.details');

      });



    //    Deposit Controller



    Route::post('/deposit/stripe-submit', [StripeController::class,'store'])->name('buyer.deposit.stripe.submit');



    Route::post('/deposit/mercadopago-submit', [MercadopagoController::class,'store'])->name('deposit.mercadopago.submit');



    Route::post('/deposit/paystack/submit', [PaystackController::class,'store'])->name('deposit.paystack.submit');



    Route::post('/paypal-submit', [PaypalController::class,'store'])->name('buyer.deposit.paypal.submit');

    Route::get('/paypal/deposit/notify', [PaypalController::class,'notify'])->name('buyer.deposit.paypal.notify');

    Route::get('/paypal/deposit/cancle', [PaypalController::class,'cancel'])->name('buyer.deposit.paypal.cancel');



    Route::post('/deposit/skrill-submit', [SkrillController::class,'store'])->name('buyer.deposit.skrill.submit');

    Route::any('/deposit/skrill-notify', [SkrillController::class,'notify'])->name('buyer.deposit.skrill.notify');



    Route::post('/deposit/perfectmoney-submit', [PerfectMoneyController::class,'store'])->name('deposit.perfectmoney.submit');

    Route::any('/deposit/perfectmoney-notify', [PerfectMoneyController::class,'notify'])->name('deposit.perfectmoney.notify');



    Route::post('/deposit/payeer-submit', [PayeerController::class,'store'])->name('buyer.deposit.payeer.submit');

    Route::any('/deposit/payeer-notify', [PayeerController::class,'notify'])->name('buyer.deposit.payeer.notify');



    Route::post('/instamojo-submit',[InstamojoController::class,'store'])->name('buyer.deposit.instamojo.submit');

    Route::get('/instamojo-notify',[InstamojoController::class,'notify'])->name('buyer.deposit.instamojo.notify');



    Route::post('/deposit/paytm-submit', [PaytmController::class,'store'])->name('buyer.deposit.paytm.submit');

    Route::post('/deposit/paytm-callback', [PaytmController::class,'paytmCallback'])->name('buyer.deposit.paytm.notify');



    Route::post('/deposit/razorpay-submit', [RazorpayController::class,'store'])->name('buyer.deposit.razorpay.submit');

    Route::post('/deposit/razorpay-notify', [RazorpayController::class,'notify'])->name('buyer.deposit.razorpay.notify');



    Route::post('/deposit/molly-submit', [MollieController::class,'store'])->name('deposit.molly.submit');

    Route::get('/deposit/molly-notify', [MollieController::class,'notify'])->name('deposit.molly.notify');



    Route::post('/deposit/flutter/submit', [FlutterwaveController::class,'store'])->name('buyer.deposit.flutter.submit');

    Route::post('/deposit/flutter/notify', [FlutterwaveController::class,'notify'])->name('buyer.deposit.flutter.notify');



    Route::post('/authorize-submit', [AuthorizeController::class,'store'])->name('buyer.deposit.authorize.submit');

    Route::post('/deposit/manual-submit', [ManualController::class,'store'])->name('buyer.deposit.manual.submit');



    Route::post('/deposit/coinpayment-submit', [CoinpaymentController::class,'deposit'])->name('deposit.coinpay.submit');

    Route::post('/deposit/coinpayment/notify', [CoinpaymentController::class,'coincallback'])->name('deposit.coinpay.notify');

    Route::get('/deposit/coinpayment', [CoinpaymentController::class,'blockInvest'])->name('deposit.coinpay.invest');



    Route::post('/deposit/blockio-submit', [BlockIoController::class,'deposit'])->name('deposit.blockio.submit');

    Route::post('/deposit/blockio/notify', [BlockIoController::class,'blockiocallback'])->name('deposit.blockio.notify');

    Route::get('/deposit/blockio', [BlockIoController::class,'blockioDeposit'])->name('blockio.deposit');



    

    Route::get('/job/allorder', [JobOrderController::class,'allorder'])->name('buyer.job.allorder');

    Route::group(['middleware'=>'kyc:Job Order'],function(){

    Route::post('/job/order/complete/{id}', [JobOrderController::class,'store'])->name('buyer.job.order.complete');

    Route::get('/job/order-details/{id}',[JobOrderController::class,'details'])->name('buyer.job.order.details');

    });







    Route::get('/all/service/order', [ServiceOrderController::class,'allorder'])->name('buyer.service.allorder');

    Route::group(['middleware'=>'kyc:Service Order'],function(){

    Route::post('/service/order/complete/{id}', [ServiceOrderController::class,'ordercomplete'])->name('buyer.service.order.complete');

    Route::get('/service/order-details/{id}',[ServiceOrderController::class,'details'])->name('buyer.service.order.details');

    });



    // Service Conversation Route

    Route::get('service/conversation/{id}',[ServiceConversationController::class,'index'])->name('buyer.service.conversation');

    Route::post('service/conversation/{id}',[ServiceConversationController::class,'store'])->name('buyer.service.conversation.store');





    Route::get('support-tickets', [MessageController::class,'index'])->name('buyer.message.index');

    Route::get('create/support-tickets', [MessageController::class,'create'])->name('buyer.message.create');

    Route::post('support-tickets/store', [MessageController::class,'store'])->name('buyer.message.store');

    Route::get('support-tickets/show/{id}', [MessageController::class,'show'])->name('buyer.message.show');

    Route::post('support-tickets/conversation/{id}', [MessageController::class,'conversation'])->name('buyer.message.conversation');

    Route::get('admin/message/{id}/delete', [MessageController::class,'adminmessagedelete'])->name('buyer.message.delete1');



    Route::get('/profile', [UserController::class,'profile'])->name('buyer.profile.index');

    Route::post('/profile', [UserController::class,'profileupdate'])->name('buyer.profile.update');



    Route::get('/2fa-security', [UserController::class,'showTwoFactorForm'])->name('buyer.show2faForm');

    Route::post('/createTwoFactor', [UserController::class,'createTwoFactor'])->name('buyer.createTwoFactor');

    Route::post('/disableTwoFactor', [UserController::class,'disableTwoFactor'])->name('buyer.disableTwoFactor');



    Route::get('/change-password', [UserController::class,'changePasswordForm'])->name('buyer.change.password.form');

    Route::post('/change-password', [UserController::class,'changePassword'])->name('buyer.change.password');

    });



    Route::get('/logout', [LoginController::class,'logout'])->name('buyer.logout');

});