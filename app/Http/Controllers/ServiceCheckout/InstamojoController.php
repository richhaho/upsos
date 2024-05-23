<?php

namespace App\Http\Controllers\ServiceCheckout;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Classes\Instamojo;
use App\Models\Currency;
use App\Repositories\ServiceRepository;
use Brian2694\Toastr\Facades\Toastr;

class InstamojoController extends Controller
{
    public $serviceRepository;
    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $data = PaymentGateway::whereKeyword('instamojo')->first();
        $gs = Generalsetting::first();
        $total =  $request->total;
        $currency = Currency::whereId($request->currency_id)->first();
        $amount =  $request->total;
        $paydata = $data->convertAutoData();
        if($request->currency_code != "INR")
        {
            Toastr::error('Please Select INR Currency For This Payment.');
            return redirect()->back();
        }
        $order['item_name'] = $gs->title."Service Order";
        $order['item_number'] = Str::random(4).time();
        $order['item_amount'] = $total;
        $cancel_url = route('service.instamojo.cancel');
        $notify_url = route('service.instamojo.notify');
        if($paydata['sandbox_check'] == 1){
            $api = new Instamojo($paydata['key'], $paydata['token'], 'https://test.instamojo.com/api/1.1/');
        }
        else {
            $api = new Instamojo($paydata['key'], $paydata['token']);
        }
        try {
            $response = $api->paymentRequestCreate(array(
                "purpose" => $order['item_name'],
                "amount" => $order['item_amount'],
                "send_email" => true,
                "email" => auth()->user()->email,
                "redirect_url" => $notify_url
            ));
            $redirect_url = $response['longurl'];
            Session::put('input_data',$input);
            Session::put('order_data',$order);
            Session::put('order_payment_id', $response['id']);
            return redirect($redirect_url);
        }
        catch (Exception $e) {
            return redirect($cancel_url)->with('unsuccess','Error: ' . $e->getMessage());
        }
    }
    public function notify(Request $request)
    {
        $input_data = $request->all();

        $payment_id = Session::get('order_payment_id');

        if($input_data['payment_status'] == 'Failed'){
        
            Toastr::error('Payment Failed.');
            return redirect()->route('front.allservices');
           
        }
        if ($input_data['payment_request_id'] == $payment_id) {

            $addionalData = ['txnid'=>$payment_id];
            $this->orderRepositorty->OrderFromSession($request,'complete',$addionalData);
            Toastr::success('Payment Success.');
            return redirect()->route('front.allservices');
        }
        Toastr::error('Payment Failed.');
        return redirect()->route('front.allservices');
    }
    public function cancel(){
        Toastr::error('Payment Failed.');
        return redirect()->route('front.allservices');
        
    }
}
