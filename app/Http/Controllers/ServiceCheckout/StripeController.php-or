<?php

namespace App\Http\Controllers\ServiceCheckout;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repositories\ServiceRepository;
use Brian2694\Toastr\Facades\Toastr;
use Validator;
use Config;

class StripeController extends Controller
{
    public $serviceRepository;
    public  $allusers = [];

    public function __construct(ServiceRepository $serviceRepository)
    {
        $data = PaymentGateway::whereKeyword('Stripe')->first();
        $paydata = $data->convertAutoData();

        Config::set('services.stripe.key', $paydata['key']);
        Config::set('services.stripe.secret', $paydata['secret']);

        $this->serviceRepository = $serviceRepository;
    }

    public function store(Request $request){

        // dd($request->all());
        
        $gs = Generalsetting::findOrFail(1);
        $item_name = $gs->title."Service Order";
        $item_number = Str::random(4).time();
        $item_amount = $request->total;
        $support = ['USD'];
        if(!in_array($request->currency_code,$support)){
            Toastr::error('Please Select USD Currency For Stripe.');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(),[
                        'cardNumber' => 'required',
                        'cardCVC' => 'required',
                        'month' => 'required',
                        'year' => 'required',
                    ]);
        if ($validator->passes()) {

            $stripe = Stripe::make(Config::get('services.stripe.secret'));
            try{
                $token = $stripe->tokens()->create([
                    'card' =>[
                            'number' => $request->cardNumber,
                            'exp_month' => $request->month,
                            'exp_year' => $request->year,
                            'cvc' => $request->cardCVC,
                        ],
                    ]);
                if (!isset($token['id'])) {
                    return back()->with('error','Token Problem With Your Token.');
                }

                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => $request->currency_code,
                    'amount' => $item_amount,
                    'description' => $item_name,
                    ]);

                if ($charge['status'] == 'succeeded') {
                    $addionalData = ['item_number'=>$item_number,'txnid'=>$charge['balance_transaction'],'charge_id'=>$charge['id'],'payment_method'=>'Stripe'];
                    $this->serviceRepository->order($request,'running',$addionalData);

                    Toastr::success('Payment Successfully.');
                    return redirect()->route('front.allservices');
                   
                }

            }catch (Exception $e){
                return back()->with('unsuccess', $e->getMessage());
            }catch (\Cartalyst\Stripe\Exception\CardErrorException $e){
                return back()->with('unsuccess', $e->getMessage());
            }catch (\Cartalyst\Stripe\Exception\MissingParameterException $e){
                return back()->with('unsuccess', $e->getMessage());
            }
        }
        Toastr::error('Please Enter Valid Credit Card Informations.');
        return back();
        
    }
}
