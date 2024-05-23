<?php

namespace App\Http\Controllers\ServiceCheckout;

use App\Models\Service;
use Carbon\Carbon;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Repositories\ServiceRepository;
use Brian2694\Toastr\Facades\Toastr;
use Stripe\StripeClient;
use Validator;
use Config;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public $serviceRepository;
    public  $allusers = [];

    public function __construct(ServiceRepository $serviceRepository)
    {
        $data = PaymentGateway::whereKeyword('Stripe')->first();
        $paydata = $data->convertAutoData();

        $this->stripePublicKey = Config::set('services.stripe.key', $paydata['key']);
        $this->stripeSecretKey = Config::set('services.stripe.secret', $paydata['secret']);

        $this->serviceRepository = $serviceRepository;

        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function create(Request $request): \Illuminate\Http\RedirectResponse
    {
        $item_amount = $request->total;
        $support = ['USD'];

        if(!in_array($request->currency_code, $support)){
            Toastr::error('Please Select USD Currency For Stripe.');
            return redirect()->back();
        }

        $successUrl = route('service.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}';

        $service = Service::query()->where('id', $request->service_id)->first();
        $serviceId = $service->id;
        $service->icon_url = str_contains($service->image, 'http') ? $service->image : asset('storage/' . $service->image);

        $line_items[] = [
            'price_data' => [
                'currency' => 'USD',
                'product_data' => [
                    'name' => $service->title,
                    'images' => [$service->image],
                ],
                'unit_amount' => $item_amount * 100,
                'tax_behavior' => 'exclusive',
            ],
            'quantity' => 1,
        ];

        $response = $this->stripe->checkout->sessions->create([
            'submit_type' => 'pay',
            'locale' => 'auto',
            'metadata' => [
                'service_id' => $serviceId,
                'address' => $request->address,
                'details' => $request->details,
                'schedule' => $request->schedule,
                'package_fee' => $request->package_fee,
                'phone' => $request->phone,
                'country' => $request->country_id,
                'city' => $request->city_id,
                'area' => $request->area_id,
                'include' => is_array($request->include) ? implode(',', $request->include) : $request->include,
                'quantity' => is_array($request->quantity) ? implode(',', $request->quantity) : $request->quantity,
                'additional_service_cost' => $request->additional_service_cost,
                'tax' => $request->tax,
                'total' => $request->total,
                'date' => $request->date,
                'ref_id' => $request->ref_id,
                'token' => $request->token,
                'currency_sign' => $request->currency_sign,
                'currency_value' => $request->currency_value,
                'currency_code' => $request->currency_code,
            ],
            'success_url' => $successUrl,
            'payment_method_types' => ['link', 'card'],
            'line_items' => $line_items,
            "expires_at" => Carbon::now()->addMinutes(30)->timestamp,
            'mode' => 'payment',
            'customer_email' => $request->email,
        ]);

        return redirect()->to($response->url);
    }

    public function success(Request $request): \Illuminate\Http\RedirectResponse
    {
        $gs = Generalsetting::findOrFail(1);
        $item_name = $gs->title."Service Order";
        $item_number = Str::random(4).time();
        $sessionId = $request->get('session_id');

//        if (!$sessionId) {
//            return back()->with('error','Token Problem With Your Token.');
//        }

        $session = $this->stripe->checkout->sessions->retrieve($sessionId);

        $service = Service::find($session->metadata['service_id']);
        $request['service_id'] = $session->metadata['service_id'];
        $request['seller_id'] = $service->seller_id;
        $request['buyer_id'] = Auth::user()->id;
        $request['name'] = $session->customer_details->name;
        $request['email'] = $session->customer_details->email;
        $request['phone'] = $session->metadata['phone'];
        $request['address'] = $session->metadata['address'];
        $request['details'] = $session->metadata['details'];
        $request['country_id'] = $session->metadata['country'];
        $request['city_id'] = $session->metadata['city'];
        $request['area_id'] = $session->metadata['area'];
        $request['date'] = $session->metadata['date'];
        $request['schedule'] = $session->metadata['schedule'];
        $request['package_fee'] = $session->metadata['package_fee'];
        $request['include'] = $session->metadata['include'];
        $request['quantity'] = $session->metadata['quantity'];
        $request['additional_service_cost'] = $session->metadata['additional_service_cost'];
        $request['tax'] = $session->metadata['tax'];
        $request['total'] = $session->metadata['total'];
        $request['commission_amount'] = commissionCalculate($session->metadata['total']);
        $request['currency_sign'] = $session->metadata['currency_sign'];
        $request['currency_value'] = $session->metadata['currency_value'];
        $request['currency_code'] = $session->metadata['currency_code'];

        DB::beginTransaction();

        try {
            $addionalData = [
                'item_number' => $item_number,
                'txnid' => $item_name,
                'charge_id' => $session->id,
                'payment_method' => 'Stripe'
            ];

            $this->serviceRepository->order($request,'running',$addionalData);
            DB::commit();
            Toastr::success('Payment Successfully.');
            return redirect()->route('front.allservices');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error("Payment Success Handling Error: " . $e->getMessage());
            return back()->with('error','Payment Failed.');
        }
    }

//    public function store(Request $request) {
//        // dd($request->all());
//        $gs = Generalsetting::findOrFail(1);
//        $item_name = $gs->title."Service Order";
//        $item_number = Str::random(4).time();
//        $item_amount = $request->total;
//        $support = ['USD'];
//        if(!in_array($request->currency_code,$support)){
//            Toastr::error('Please Select USD Currency For Stripe.');
//            return redirect()->back();
//        }
//
//        $validator = Validator::make($request->all(),[
//                        'cardNumber' => 'required',
//                        'cardCVC' => 'required',
//                        'month' => 'required',
//                        'year' => 'required',
//                    ]);
//        if ($validator->passes()) {
//
//            $stripe = Stripe::make(Config::get('services.stripe.secret'));
//            try{
//                $token = $stripe->tokens()->create([
//                    'card' =>[
//                            'number' => $request->cardNumber,
//                            'exp_month' => $request->month,
//                            'exp_year' => $request->year,
//                            'cvc' => $request->cardCVC,
//                        ],
//                    ]);
//                if (!isset($token['id'])) {
//                    return back()->with('error','Token Problem With Your Token.');
//                }
//
//                $charge = $stripe->charges()->create([
//                    'card' => $token['id'],
//                    'currency' => $request->currency_code,
//                    'amount' => $item_amount,
//                    'description' => $item_name,
//                    ]);
//
//                if ($charge['status'] == 'succeeded') {
//                    $addionalData = ['item_number'=>$item_number,'txnid'=>$charge['balance_transaction'],'charge_id'=>$charge['id'],'payment_method'=>'Stripe'];
//                    $this->serviceRepository->order($request,'running',$addionalData);
//
//                    Toastr::success('Payment Successfully.');
//                    return redirect()->route('front.allservices');
//
//                }
//
//            }catch (Exception $e){
//                return back()->with('unsuccess', $e->getMessage());
//            }catch (\Cartalyst\Stripe\Exception\CardErrorException $e){
//                return back()->with('unsuccess', $e->getMessage());
//            }catch (\Cartalyst\Stripe\Exception\MissingParameterException $e){
//                return back()->with('unsuccess', $e->getMessage());
//            }
//        }
//        Toastr::error('Please Enter Valid Credit Card Informations.');
//        return back();
//
//    }
}
