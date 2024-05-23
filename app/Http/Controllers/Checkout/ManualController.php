<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Str;

class ManualController extends Controller
{
    public $gs;
    public  $allusers = [];
    public $referral_ids = [];

    public function __construct()
    {
        $this->gs = Generalsetting::findOrFail(1);
    }

    public function store(Request $request){

        $plan = Plan::whereId($request->plan_id)->first();
        $item_name = $this->gs->title."Subscription";
        $item_number = Str::random(4).time();
        $item_amount = baseCurrencyAmount($request->amount);
        $order = new UserSubscription();

        
        $order['transaction_no'] = $item_number;
        $order['user_id'] = $request->user_id;
        $order['planid'] = $plan->id;
        $order['currency_id'] = $request->currency_id;
        $order['method'] = $request->method;
        $order['amount'] = $item_amount;
        $order['payment_status'] = "pending";
        $order['txnid'] = $request->txn_id4;
        $order['connect']=$request->connect;
        $order['plan_type']=$request->plan_type;
        $order['status']=0;
        
        $order->save();

        $user = User::whereId($order->user_id)->first();
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
        if($order->plan_type == 'lifetime'){
            $user->plan_expiredate = Carbon::parse($user->plan_expiredate)->addYears(100);
        }
        $user->save();
        $this->gs = Generalsetting::findOrFail(1);
        $to = $user->email;
        $subject = 'Subscription';
        $msg = "Dear Customer,<br> Your invest in process.";
        
        if($this->gs->is_smtp == 1)
        {

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = $this->gs->smtp_host;
                $mail->SMTPAuth   = true;
                $mail->Username   = $this->gs->smtp_user;
                $mail->Password   = $this->gs->smtp_pass;
                if ($this->gs->smtp_encryption == 'ssl') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                } else {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                }
                $mail->Port       = $this->gs->smtp_port;
                $mail->CharSet = 'UTF-8';
                $mail->setFrom($this->gs->from_email, $this->gs->from_name);
                $mail->addAddress($user->email, $user->name);
                $mail->addReplyTo($this->gs->from_email, $this->gs->from_name);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $msg;
                $mail->send();
            } catch (Exception $e) {

            }
        }
        else
        {
            $headers = "From: ".$this->gs->from_name."<".$this->gs->from_email.">";
            mail($to,$subject,$msg,$headers);
        }
        return redirect()->route('user.invest.plans')->with('message','Subscription successfully complete.');
    }

    public function free(Request $request){

        $check = UserSubscription::where('user_id','=',$request->user_id)->where('amount','=',0)->first();
        if($check){
            Toastr::error('You have already subscribed to a free plan.','Error');
            return redirect()->back()->with('unsuccess','You have already subscribed to a free plan.');
           
        }

      

        $plan = Plan::whereId($request->plan_id)->first();
        $item_name = $this->gs->title."Subscription";
        $item_number = Str::random(4).time();
        $item_amount = baseCurrencyAmount($request->amount);
        $order = new UserSubscription();

        
        $order['transaction_no'] = $item_number;
        $order['user_id'] = $request->user_id;
        $order['planid'] = $plan->id;
        $order['currency_id'] = $request->currency_id;
        $order['method'] = $request->method;
        $order['amount'] = $item_amount;
        $order['payment_status'] = "completed";
        $order['txnid'] = 'freesubscription';
        $order['connect']=$request->connect;
        $order['plan_type']=$request->plan_type;
        $order['status']=0;
        
        $order->save();

        $user = User::whereId($order->user_id)->first();
        
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
            $user->plan_expiredate = Carbon::parse($user->plan_expiredate)->addYears(5);
        }
        $user->save();
        $this->gs = Generalsetting::findOrFail(1);
        $to = $user->email;
        $subject = 'Subscription';
        $msg = "Dear Customer,<br> Your Subscription in process.";
        
        if($this->gs->is_smtp == 1)
        {

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = $this->gs->smtp_host;
                $mail->SMTPAuth   = true;
                $mail->Username   = $this->gs->smtp_user;
                $mail->Password   = $this->gs->smtp_pass;
                if ($this->gs->smtp_encryption == 'ssl') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                } else {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                }
                $mail->Port       = $this->gs->smtp_port;
                $mail->CharSet = 'UTF-8';
                $mail->setFrom($this->gs->from_email, $this->gs->from_name);
                $mail->addAddress($user->email, $user->name);
                $mail->addReplyTo($this->gs->from_email, $this->gs->from_name);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $msg;
                $mail->send();
            } catch (Exception $e) {

            }
        }
        else
        {
            $headers = "From: ".$this->gs->from_name."<".$this->gs->from_email.">";
            mail($to,$subject,$msg,$headers);
        }
        Toastr::success('Subscription successfully complete.','Success');
        return redirect()->back()->with('message','Subscription successfully complete.');
        
    }
}
