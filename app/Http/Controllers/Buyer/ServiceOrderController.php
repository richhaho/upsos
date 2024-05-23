<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Generalsetting;
use App\Models\Serviceincludes;
use App\Models\ServiceOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceOrderController extends Controller
{
    public function allorder(){

        $serviceorder= ServiceOrder::where('buyer_id',Auth::id())->paginate(10);
        return view('buyer.serviceorder.allorder',compact('serviceorder'));
    }

    public function ordercomplete($id){
        

        $serviceorder = ServiceOrder::findOrFail($id);
        $commission = new Commission();
        $gs = Generalsetting::findOrFail(1);
 
        $commission->commision_from= 'seller';
        $commission->commission_method= 'serviceorder';
        $commission->commision_charge = $serviceorder->commission_amount;

        $commission->save();
        $user= User::findOrFail($serviceorder->seller_id);
        $user->balance = $user->balance + ($serviceorder->total - $commission->commision_charge);
       
        $user->save();

        $serviceorder->update([
            'order_complete_request' => 2,
            'status' => 2,
        ]);
        return redirect()->back()->with('success', 'Order Approved!');

    }

    public function details($id){
        $serviceorder= ServiceOrder::where('id', $id)->first();
        $serviceincludes =  Serviceincludes::where('service_id', $serviceorder->service_id)->get();
        return view('buyer.serviceorder.details', compact('serviceorder', 'serviceincludes'));
    }



}
