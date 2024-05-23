<?php

namespace App\Http\Controllers\ServiceCheckout;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use App\Models\Generalsetting;
use App\Models\PaymentGateway;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Repositories\ServiceRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    public $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $data = PaymentGateway::whereKeyword('razorpay')->first();
        $paydata = $data->convertAutoData();
        $this->keyId = $paydata['key'];
        $this->keySecret = $paydata['secret'];
        $this->displayCurrency = 'INR';
        $this->api = new Api($this->keyId, $this->keySecret);

        $this->serviceRepository = $serviceRepository;
    }


    public function store(Request $request)
    {
        $service= Service::findOrFail($request->service_id);
        if($request->currency_code != "INR")
        {
            Toastr::error('Please Select INR Currency For Rezorpay.');
            return redirect()->back();
        }
        
        $settings = Generalsetting::findOrFail(1);
        $order = new ServiceOrder();
        $item_name = $settings->title."Service Payment";
        $item_number = Str::random(12);

        $currency = Currency::whereId($request->currency_id)->first();
        $amountToAdd =  $request->total;
       
        $order['item_name'] = $item_name;
        $order['item_number'] = $item_number;
        $order['item_amount'] = $amountToAdd;
        $cancel_url = route('service.paypal.cancel');
        $notify_url = route('service.razorpay.notify');


        $orderData = [
            'receipt'         => $order['item_number'],
            'amount'          => $order['item_amount'] * 100,
            'currency'        => 'INR',
            'payment_capture' => 1
        ];
        
        $razorpayOrder = $this->api->order->create($orderData);

        $input['user_id'] = auth()->user()->id;
        
        Session::put('input_data',$request->all());
        Session::put('order_data',$order);
        Session::put('order_payment_id', $razorpayOrder['id']);

        $displayAmount = $amount = $orderData['amount'];
                    
        if ($this->displayCurrency !== 'INR')
        {
            $url = "https://api.fixer.io/latest?symbols=$this->displayCurrency&base=INR";
            $exchange = json_decode(file_get_contents($url), true);
        
            $displayAmount = $exchange['rates'][$this->displayCurrency] * $amount / 100;
        }
        
        $checkout = 'automatic';
        
        if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
        {
            $checkout = $_GET['checkout'];
        }
        
        $data = [
            "key"               => $this->keyId,
            "amount"            => $amount,
            "name"              => $order['item_name'],
            "description"       => $order['item_name'],
            "prefill"           => [
                "name"              => $request->customer_name,
                "email"             => $request->customer_email,
                "contact"           => $request->customer_phone,
            ],
            "notes"             => [
                "address"           => $request->customer_address,
                "merchant_order_id" => $order['item_number'],
            ],
            "theme"             => [
                "color"             => "{{$settings->colors}}"
            ],
            "order_id"          => $razorpayOrder['id'],
        ];
        
        if ($this->displayCurrency !== 'INR')
        {
            $data['display_currency']  = $this->displayCurrency;
            $data['display_amount']    = $displayAmount;
        }
        
        $json = json_encode($data);
       
        $displayCurrency = $this->displayCurrency;
        
        return view( 'frontend.razorpay-checkout', compact( 'data','displayCurrency','json','notify_url' ) );
    }

    public function notify(Request $request)
    {
        $input_data = $request->all();
       
        $payment_id = Session::get('order_payment_id');

        $success = true;

        if (empty($input_data['razorpay_payment_id']) === false)
        {
        
            try
            {
                $attributes = array(
                    'razorpay_order_id' => $payment_id,
                    'razorpay_payment_id' => $input_data['razorpay_payment_id'],
                    'razorpay_signature' => $input_data['razorpay_signature']
                );
        
                $this->api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
            }
        }


        if ($success === true){
            $addionalData = ['payment_method'=>'razorpay','txnid'=>$payment_id,'pay_id'=>$input_data['razorpay_payment_id']];
            $this->serviceRepository->OrderFromSession($request,'complete',$addionalData);

            Toastr::success('Payment Successfully Completed.');
            return redirect()->route('front.allservices');

            
        }
        Toastr::error('Payment Failed.');
        return redirect()->route('front.allservices');
    }
}
