<?php

namespace App\Http\Controllers\ServiceCheckout;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Generalsetting;
use App\Repositories\ServiceRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class AuthorizeController extends Controller
{
    public $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function store(Request $request){
        $support = ['USD','AUD','CAD','CHF','DKK','EUR','GBP','JPY','NOK','NZD','SEK','USD','ZAR'];
        if(!in_array($request->currency_code,$support)){
            Toastr::error('Sorry! This Currency is not supported by Authorize.net');
            return back();
        }
        
        $settings = Generalsetting::find(1);
        
        $authorizeinfo    = PaymentGateway::whereKeyword('authorize.net')->first();
        $authorizesettings= $authorizeinfo->convertAutoData();

        $item_name = $settings->title." Order";
        $item_number = Str::random(4).time();
        $item_amount = $request->total;
        
     
        $validator = Validator::make($request->all(),[
            'cardautho' => 'required',
            'cardCVC' => 'required',
            'month' => 'required',
            'year' => 'required',
        ]);

        if ($validator->passes()) {
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName($authorizesettings['login_id']);
            $merchantAuthentication->setTransactionKey($authorizesettings['txn_key']);

            $refId = 'ref' . time();

            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber(str_replace(' ','',$request->cardautho));
            $year = $request->year;
            $month = $request->month;
            $creditCard->setExpirationDate($year.'-'.$month);
            $creditCard->setCardCode($request->cardCVC);

            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setCreditCard($creditCard);
        
            $orderr = new AnetAPI\OrderType();
            $orderr->setInvoiceNumber($item_number);
            $orderr->setDescription($item_name);

            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction"); 
            $transactionRequestType->setAmount($item_amount);
            $transactionRequestType->setOrder($orderr);
            $transactionRequestType->setPayment($paymentOne);
  
            $requestt = new AnetAPI\CreateTransactionRequest();
            $requestt->setMerchantAuthentication($merchantAuthentication);
            $requestt->setRefId($refId);
            $requestt->setTransactionRequest($transactionRequestType);
        
            $controller = new AnetController\CreateTransactionController($requestt);
            if($authorizesettings['sandbox_check'] == 1){
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
            }
            else {
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);                
            }

        
            if ($response != null) {
                if ($response->getMessages()->getResultCode() == "Ok") {
                    $tresponse = $response->getTransactionResponse();

                
                    if ($tresponse != null && $tresponse->getMessages() != null) {
                        $addionalData = [ 'payment_method'=>'authorize.net','item_number'=>$item_number,'txnid'=>$tresponse->getTransId()];
                        $this->serviceRepository->order($request,'running',$addionalData);

                        Toastr::success('Payment Successfull');
                        return redirect()->back();
                    } else {
                        Toastr::warning('Payment Failed');
                        return back();
                    }
                } else {

                    Toastr::warning('Payment Failed');
                    return back();
                }      
            } else {
                Toastr::warning('Payment Failed');
                return back();
            }

        }
        Toastr::warning('Invalid Payment Details');
        return back();
        
    }
}
