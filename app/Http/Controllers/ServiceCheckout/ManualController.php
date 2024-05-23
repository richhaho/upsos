<?php

namespace App\Http\Controllers\ServiceCheckout;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Invest;
use App\Models\Notification;
use App\Models\Plan;
use App\Models\Referral;
use App\Models\ReferralBonus;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserSubscription;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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

       

        $service=Service::findOrFail($request->service_id);
        $item_name = $this->gs->title."Service Order";
        $item_number = Str::random(4).time();
        $item_amount = $request->total;
        $order = new ServiceOrder();

        
        $order['transaction_no'] = $item_number;
        $order['service_id'] = $request->service_id;
        $order['seller_id'] = $service->seller_id;
        $order['buyer_id'] = Auth::user()->id;
        $order['name'] = $request->name;
        $order['email'] = $request->email;
        $order['phone'] = $request->phone;
        $order['address'] = $request->address;
        $order['details'] = $request->details;
        $order['country_id'] = $request->country_id;
        $order['city_id'] = $request->city_id;
        $order['area_id'] = $request->area_id;
        $order['date'] = $request->date;
        $order['schedule'] = $request->schedule;
        $order['package_fee'] = baseCurrencyAmount($request->package_fee);
        if(!empty($request->incldue)){
            $order['include'] = json_encode($request->incldue);
        }
        else{
            $order['include'] = null;
        }

        if(!empty($request->quantity)){
            $order['quantity'] = json_encode($request->quantity);
        }
        else{
            $order['quantity'] = null;
        }
        $order['additional_service_cost'] = baseCurrencyAmount($request->additional_service_cost);
        $order['tax'] = baseCurrencyAmount($request->tax);
        $order['total'] = baseCurrencyAmount($request->total);
        $order['commission_type'] = $this->gs->commission_type== 1 ? "percent" : "amount";
        $order['commission_charge'] = $this->gs->commission_price;
        $order['commission_amount'] = baseCurrencyAmount(commissionCalculate($request->total));
        $order['payment_method'] = 'Manual';
        $order['status']=0;
        $order['is_online']=$service->is_service_online;
        $order['currency_sign'] = $request->currency_sign;
        $order['currency_value'] = $request->currency_value;
        $order['created_at'] = Carbon::now();
        $order['payment_status'] = "pending";
        $order['txnid'] = $request->txn_id4;
        $order['status']=0;
        $order->save();

        $notification = new Notification();
        $notification->order_id = $order->id;
        $notification->user_id = $order->seller_id;
        $notification->type = "service";
        $notification->message = 'You have a new service order';
        $notification->is_read = 0;
        $notification->save();


        $trans = new Transaction();
        $trans->email = auth()->user()->email;
        $trans->amount = $order->total;
        $trans->type = "service";
        $trans->txnid = $order->transaction_no;
        $trans->user_id = $order->buyer_id;
        $trans->profit= 'minus';
        $trans->save();


        $user = User::whereId($order->buyer_id)->first();
        $this->gs = Generalsetting::findOrFail(1);
        $to = $user->email;
        $subject = 'Service Order';
        $msg = "Dear Customer,<br> Your Service in process.";
        
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
        Toastr::success('Service Order Successfully');
        return redirect()->route('front.allservices');
    }
}
