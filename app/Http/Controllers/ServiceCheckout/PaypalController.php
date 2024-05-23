<?php

namespace App\Http\Controllers\ServiceCheckout;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Generalsetting;

use App\Models\PaymentGateway;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use PayPal\{
    Api\Item,
    Api\Payer,
    Api\Amount,
    Api\Payment,
    Api\ItemList,
    Rest\ApiContext,
    Api\Transaction,
    Api\RedirectUrls,
    Api\PaymentExecution,
    Auth\OAuthTokenCredential
};
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Repositories\ServiceRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;

class PaypalController extends Controller
{
    private $_api_context;
    public $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $data = Paymentgateway::whereKeyword('paypal')->first();
        $paydata = $data->convertAutoData();
        
        $paypal_conf = \Config::get('paypal');
        $paypal_conf['client_id'] = $paydata['client_id'];
        $paypal_conf['secret'] = $paydata['client_secret'];
        $paypal_conf['settings']['mode'] = $paydata['sandbox_check'] == 1 ? 'sandbox' : 'live';
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

        $this->serviceRepository = $serviceRepository;
    }

    public function store(Request $request){

 
        
        $cancel_url = route('service.paypal.cancel');
        $notify_url = route('service.paypal.notify');

        $gs = Generalsetting::findOrFail(1);
        $item_name = $gs->title."Service Payment";
        $item_number = Str::random(4).time();
        $item_amount = $request->total;
        
        $support = ['USD','EUR'];
        if(!in_array($request->currency_code,$support)){
            Toastr::error('Sorry! Paypal does not support your currency.');
            return back();
        }
        
        
        $addionalData = ['item_number'=>$item_number,'payment_method'=>'paypal'];
        $this->serviceRepository->order($request,'pending',$addionalData);
        

        $currency = Currency::whereId($request->currency_id)->first();
        $amountToAdd = $item_amount/$currency->value;


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($item_name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($amountToAdd);
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($amountToAdd);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($item_name.' Via Paypal');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl($notify_url)
            ->setCancelUrl($cancel_url);
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
            
            
            try {
                $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
                Toastr::error($ex->getMessage());
                return back();
            }
            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
           
            Session::put('paypal_data',$request->all());
            Session::put('paypal_payment_id', $payment->getId());
            Session::put('order_number',$item_number);

            if (isset($redirect_url)) {
                return Redirect::away($redirect_url);
            }

            Toastr::error('Unknown error occurred');
            return redirect()->back();

            if (isset($redirect_url)) {
                return Redirect::away($redirect_url);
            }
            Toastr::error('Unknown error occurred');
            return redirect()->back();

    }

    public function notify(Request $request)
    {
        $payment_id = Session::get('paypal_payment_id');
        if (empty( $request['PayerID']) || empty( $request['token'])) {
            Toastr::error('Payment failed');
            return redirect()->back(); 
        } 

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request['PayerID']);

        $trx = Session::get('order_number');

        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $resp = json_decode($payment, true);

            $order = ServiceOrder::where('transaction_no',$trx)->where('payment_status','pending')->first();
            $data['txnid'] = $resp['transactions'][0]['related_resources'][0]['sale']['id'];
            $data['payment_status'] = "completed";
            
            $order->update($data);
            $msg= "Your Service payment has been completed.";
            $this->serviceRepository->callAfterOrder($request,$order,$msg);
            Session::forget('paypal_data');
            Session::forget('paypal_payment_id');
            Session::forget('order_number');

            Toastr::success('Payment completed');
            return redirect()->back();
        }

    }

    public function cancel(){
        Toastr::error('Payment failed');
        return redirect()->back();
    }
}
