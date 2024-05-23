<?php
namespace App\Repositories;

use App\Classes\GeniusMailer;
use App\Models\Currency;
use App\Models\Generalsetting;

use App\Models\Notification;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Referral;
use App\Models\ReferralBonus;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OrderRepository
{
    public $gs;
    public  $allusers = [];
    public $referral_ids = [];
    public function __construct()
    {
        $this->gs = Generalsetting::findOrFail(1);
    }
    public function order($request,$status,$addionalData){
        $order = new UserSubscription();
        $plan = Plan::whereId($request->plan_id)->first();
        if(isset($addionalData['item_number'])){
            $order['transaction_no'] = $addionalData['item_number'];
        }
        if($request->currency_id){
            $currencyValue = Currency::where('id',$request->currency_id)->first();
        }
        $order['user_id'] = $request->user_id;
        $order['planid'] = $plan->id;
        $order['currency_id'] = $request->currency_id;
        $order['method'] = $request->method;
        $order['connect'] = $request->connect;
        $order['plan_type'] = $request->plan_type;
        $order['status']=0;
        if($request->currency_id){
        $order['amount'] = $request->amount/$currencyValue->value;
        }
        
        $order['created_at'] = Carbon::now();
        if(isset($request->ref_id)){
            $order['txnid']=$request->ref_id;
        }

        if($status == 'running'){
            $order['payment_status'] = "completed";
        }else{
            $order['payment_status'] = "pending";
        }
        if(isset($addionalData['charge_id'])){
            $order['charge_id'] = $addionalData['charge_id'];
        }
        if(isset($addionalData['txnid'])){
            $order['txnid'] = $addionalData['txnid'];
        }
        $order->save();

        if($order->payment_status == "completed"){
            $this->UserSubscription($order);
            $order->status = 1;
            $order->update();
        }
        
        if($status == 'running'){
            $msg="New Subscription Added.";
            $this->callAfterOrder($request,$order,$msg);
        }
    }

    public function OrderFromSession($request,$status,$addionalData){
        $input = Session::get('input_data');
        if($input['currency_id']){
            $currencyValue = Currency::where('id',$input['currency_id'])->first();
        }
        $order = new UserSubscription();
        $plan = Plan::whereId($input['plan_id'])->first();
        $order['transaction_no'] = $addionalData['txnid'];
        $order['user_id'] = $input['user_id'];
        $order['planid'] = $plan->id;
        $order['currency_id'] = $input['currency_id'];
        $order['method'] = $input['method'];
        $order['txnid'] = $addionalData['pay_id'];
        $order['connect'] = $input['connect'];
        $order['plan_type'] = $input['plan_type'];
        if($input['currency_id']){
            $order['amount'] = $request->amount/$currencyValue->value;
        }else{
            $order['amount'] = $request->amount;
        }
        
        
        $order['payment_status'] = "completed";
        $order['created_at'] = Carbon::now();

        $order->save();

        if($order->payment_status == "completed"){
            $this->UserSubscription($order);
            $order->status = 1;
            $order->update();
        }
        
        $msg="New Subscription Added!";
        if($status == 'complete'){
            
        $this->callAfterOrder($request,$order,$msg);
        }
    }

    public function UserSubscription($order){

        $user = User::findOrFail($order->user_id);
        $plan = Plan::findOrFail($order->planid);
        $user->planid = $order->planid;
        $user->connect = $user->connect + $plan->connect;
        $user->service_limit = $user->service_limit + $plan->service;
        $user->job_limit = $user->job_limit + $plan->job;
        $user->plan_type = $order->plan_type;
        if($order->plan_type == 'monthly'){
            $user->plan_expiredate = Carbon::parse($user->plan_expiredate)->addMonth();
        }
        if($order->plan_type == 'yearly'){
            $user->plan_expiredate = Carbon::parse($user->plan_expiredate)->addYear();
        }
        if($order->plan_type == 'life_time'){
            $user->plan_expiredate = Carbon::now()->addYears(100);
        }
        $user->save();

    }


    public function callAfterOrder($request,$order,$msg){
        $this->createNotification($order,$msg);
        $this->createTransaction($order);
        $this->sendMail($order);
    }

    public function createNotification($order,$msg){
        $notification = new Notification();
        $notification->order_id = $order->id;
        $notification->user_id = $order->user_id;
        $notification->type = "subscription";
        $notification->message = $msg;
        $notification->is_read = 0;
        $notification->save();
    }

    public function createTransaction($order){
        $trans = new Transaction();
        $trans->email = auth()->user()->email;
        $trans->amount = $order->amount;
        $trans->type = "subscription";
        $trans->txnid = $order->transaction_no;
        $trans->user_id = $order->user_id;
        $trans->save();
    }

    public function sendMail($order){
        $user = User::whereId($order->user_id)->first();
        if($this->gs->is_smtp == 1)
        {
        $data = [
            'to' => $user->email,
            'type' => "plan",
            'cname' => $user->name,
            'oamount' => $order->amount,
            'aname' => "",
            'aemail' => "",
            'wtitle' => "",
            "onumber" => "",
        ];
        $mailer = new GeniusMailer();
        $mailer->sendAutoMail($data);
        }
        else
        {
           $to = $user->email;
           $subject = " You have Activate a plan successfully.";
           $msg = "Hello ".$user->name."!\nYou have activate a plan successfully.\nThank you.";
           $headers = "From: ".$this->gs->from_name."<".$this->gs->from_email.">";
           mail($to,$subject,$msg,$headers);
        }
    }
}
