<?php
namespace App\Repositories;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ServiceRepository
{
    public $gs;
    public  $allusers = [];
    public $referral_ids = [];
    public function __construct()
    {
        $this->gs = Generalsetting::findOrFail(1);
    }
    public function order($request, $status, $addionalData) {
        $order = new ServiceOrder();
        $service = Service::whereId($request->service_id)->first();
        if(isset($addionalData['item_number'])){
            $order['transaction_no'] = $addionalData['item_number'];
        }
        $order['service_id'] = $request->service_id;
        $order['seller_id'] = $service->seller_id;
        $order['buyer_id'] = Auth::user()->id;
        $order['name'] = $request->name;
        $order['email'] = $request->email;
        $order['phone'] = $request->phone;
        $order['address'] = $request->address;
        $order['details'] = $request->details;
        $order['country_id'] = !empty($request->country_id) ? $request->country_id : null;
        $order['city_id'] = !empty($request->city_id) ? $request->city_id : null;
        $order['area_id'] = !empty($request->area_id) ? $request->area_id : null;
        $order['date'] = $request->date;
        $order['schedule'] = $request->schedule;
        $order['package_fee'] = baseCurrencyAmount($request->package_fee);
        if(!empty($request->include)){
            $order['include'] = json_encode($request->include);
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
        $order['payment_method'] = $addionalData['payment_method'];
        $order['status']=0;
        $order['is_online']=$service->is_service_online;
        $order['currency_sign'] = $request->currency_sign;
        $order['currency_value'] = $request->currency_value;
        $order['created_at'] = Carbon::now();
        if(isset($request->ref_id)){
            $order['txnid']=$request->ref_id;
        }
        $order['schedule_status']= 1;
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

        if($status == 'running'){
            $msg="New Service Order Placed!";
            $this->callAfterOrder($request,$order,$msg);
        }
    }


    public function OrderFromSession($request,$status,$addionalData){
        $input = Session::get('input_data');
        $order = new ServiceOrder();
        $service = Service::whereId($input['service_id'])->first();
        $order['service_id'] = $input['service_id'];
        $order['seller_id'] = $service->seller_id;
        $order['buyer_id'] = Auth::user()->id;
        $order['name'] = $input['name'];
        $order['email'] =$input['email'];
        $order['phone'] =$input['phone'];
        $order['address'] = $input['address'];
        $order['details'] = $input['details'];
        $order['country_id'] = $input['country_id'];
        $order['city_id'] = $input['city_id'];
        $order['area_id'] = $input['area_id'];
        $order['date'] =$input['date'];
        $order['schedule'] =$input['schedule'];
        $order['schedule_status']= 1;
        $order['package_fee'] = baseCurrencyAmount($input['package_fee']);
        if(!empty($input['incldue'])){
            $order['include'] = json_encode($input['incldue']);
        }
        else{
            $order['include'] = null;
        }

        if(!empty($input['quantity'])){
            $order['quantity'] = json_encode($input['quantity']);
        }
        else{
            $order['quantity'] = null;
        }
        $order['additional_service_cost'] = baseCurrencyAmount($input['additional_service_cost']);
        $order['tax'] = baseCurrencyAmount($input['tax']);
        $order['total'] = baseCurrencyAmount($input['total']);
        $order['commission_type'] = $this->gs->commission_type== 1 ? "percent" : "amount";
        $order['commission_charge'] = $this->gs->commission_price;
        $order['commission_amount'] = baseCurrencyAmount(commissionCalculate($input['total']));
        $order['payment_method'] = $addionalData['payment_method'];
        $order['status']=0;
        $order['is_online']=$service->is_service_online;
        $order['currency_sign'] = $input['currency_sign'];
        $order['currency_value'] = $input['currency_value'];
        $order['created_at'] = Carbon::now();
        $order['transaction_no'] = $addionalData['txnid'];
        $order['txnid'] = $addionalData['pay_id'];

        $msg='Payment Successfull.';
        if($status == 'complete'){

            $order['payment_status'] = "completed";

            $this->callAfterOrder($request,$order,$msg);
        }
        $order->save();


    }


    public function callAfterOrder($request,$order,$msg){
        $this->createNotification($order,$msg);
        $this->createTransaction($order);
        $this->sendMail($order);
    }

    public function createNotification($order,$msg){
        $notification = new Notification();
        $notification->order_id = $order->id;
        $notification->user_id = $order->seller_id;
        $notification->type = "service";
        $notification->message = $msg;
        $notification->is_read = 0;
        $notification->save();
    }

    public function createTransaction($order){
        $trans = new Transaction();
        $trans->email = auth()->user()->email;
        $trans->amount = $order->total;
        $trans->type = "service";
        $trans->txnid = $order->transaction_no;
        $trans->user_id = $order->buyer_id;
        $trans->profit= 'minus';
        $trans->save();
    }

    public function sendMail($order){
        $user = User::whereId($order->buyer_id)->first();
        if($this->gs->is_smtp == 1)
        {
        $data = [
            'to' => $user->email,
            'type' => "Service Order",
            'cname' => $user->name,
            'oamount' => $order->total,
            'aname' => "",
            'aemail' => "",
            'wtitle' => "",
            'onumber' => $order->transaction_no,
        ];
        $mailer = new GeniusMailer();
        $mailer->sendAutoMail($data);
        }
        else
        {
           $to = $user->email;
           $subject = " You have Ordered successfully.";
           $msg = "Hello ".$user->name."!\nYou have Ordered successfully.\nThank you.";
           $headers = "From: ".$this->gs->from_name."<".$this->gs->from_email.">";
           mail($to,$subject,$msg,$headers);
        }
    }
}
