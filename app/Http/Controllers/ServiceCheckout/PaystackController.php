<?php

namespace App\Http\Controllers\ServiceCheckout;

use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaystackController extends Controller
{
    public $serviceRepositorty;
    public  $allusers = [];
    
    public function __construct(ServiceRepository $serviceRepositorty)
    {
        $this->serviceRepositorty = $serviceRepositorty;
    }

    public function store(Request $request){

       
        
        if($request->currency_code != "NGN")
        {
            Toastr::error('Please Select NGN Currency For Paystack.');
            return redirect()->back();
        }
        $service=Service::findOrFail($request->service_id);
        $gs = Generalsetting::findOrFail(1);
        $item_name = $gs->title."Purchase Service";
        $item_number = Str::random(4).time();
        $item_amount = $request->total;


        $addionalData = ['item_number'=>$item_number, 'payment_method'=>'paystack','pay_id'=>$request->ref_id];
        $this->serviceRepositorty->order($request,'running',$addionalData);

        Toastr::success('Service Order Successfully.');
        return redirect()->route('front.allservices');
       
    }
}
