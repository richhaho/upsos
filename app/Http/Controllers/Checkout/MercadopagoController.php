<?php

namespace App\Http\Controllers\Checkout;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Invest;
use App\Models\PaymentGateway;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use MercadoPago;
use Auth;

class MercadopagoController extends Controller
{
    public $orderRepositorty;

    public function __construct(OrderRepository $orderRepositorty)
    {
        $this->orderRepositorty = $orderRepositorty;
    }

    public function store(Request $request){
        $order = new UserSubscription();

        $plan = Plan::whereId($request->plan_id)->first();
        
        $gs = Generalsetting::findOrFail(1);
        $item_name = $gs->title."Subscription";
        $item_number = Str::random(4).time();

        $order['transaction_no'] = $item_number;
        $order['user_id'] = $request->user_id;
        $order['planid'] = $plan->id;
        $order['currency_id'] = $request->currency_id;
        $order['method'] = $request->method;
        $order['amount'] =rootAmount($plan->price);
        $order['payment_status'] = "pending";

        $order->save();

        $payment_amount =  $order->amount;
        $data = PaymentGateway::whereKeyword('mercadopago')->first();

        $paydata = $data->convertAutoData();
        
        MercadoPago\SDK::setAccessToken($paydata['token']);
        $payment = new MercadoPago\Payment();
        

        $payment->transaction_amount = $payment_amount;
        $payment->token = $request->token;
        $payment->description = 'Checkout '.$gs->title;
        $payment->installments = 1;
        $payment->payer = array(
        "email" => Auth::check() ? Auth::user()->email : 'example@gmail.com'
        );
        $payment->save();

        if ($payment->status == 'approved') {
            $order['payment_status'] = "completed";
            $order['txnid']=$payment->id;
            $order['connect']=$request->connect;
            $order['plan_type']=$plan->plan_type;
            $order['status']=0;
            $order->save();
         
            $msg = "Your Subscription successfully completed.";
            $this->orderRepositorty->callAfterOrder($request,$order,$msg);
            return redirect()->route('user.invest.plans')->with('message','Subscription successfully complete.');
        }else{
           
            return redirect()->route('user.invest.plans')->with('unsuccess','Something went wrong!');
        }

    }
}
