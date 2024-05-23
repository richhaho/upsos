<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\PaymentGateway;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request, $slug)
    {
        $service= Service::with('country','city')->where('slug', $slug)->first();
        $tax= City::where('id',$service->service_city_id)->first();
        if($tax){
            $tax = $tax->tax;
        }else{
            $tax = 0;
        }
        $gateways= PaymentGateway::where('status',1)->get();
        $paystack = PaymentGateway::whereKeyword('paystack')->first();
        $paystackData = $paystack->convertAutoData();
        return view('frontend.checkout', compact('service','tax', 'gateways','paystackData'));
    }

    public function getAreaList($id)
    {
        
        $areas = Area::where('city_id', $id)->get();
        return response()->json($areas);
    }

    public function getSchedule($id, $id2)
    {
        $schedule=[];
        $serviceorder=ServiceOrder::where('schedule_status',1)->where('date',$id2)->pluck('schedule')->toArray();
        $mschedule = Schedule::where('day',$id)->get();

        if(!empty($serviceorder)){
        foreach ($mschedule as $value) {
            if(!in_array($value->schedule, $serviceorder)){
                $schedule[]=$value->schedule;
            }
        }}
        else{
            foreach ($mschedule as $value) {
                $schedule[]=$value->schedule;
            }
        }
        return response()->json($schedule);
    }

    public function loadpayment($slug1,$slug2)
    {
        $data['curr'] = "USD";
        $data['payment'] = $slug1;
        $data['pay_id'] = $slug2;
        $data['gateway'] = '';
        if($data['pay_id'] != 0) {
            $data['gateway'] = PaymentGateway::findOrFail($data['pay_id']);
        }
        return view('load.payment',$data);
    }
}
