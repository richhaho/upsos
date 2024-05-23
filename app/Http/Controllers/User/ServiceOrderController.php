<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Serviceincludes;
use App\Models\ServiceOrder;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    public function index($slug)
    {
        if($slug == 'pending'){
            $serviceorder= ServiceOrder::where('seller_id', auth()->user()->id)->where('status', 0)->paginate(10);
        }
        elseif($slug == 'completed'){
            $serviceorder= ServiceOrder::where('seller_id', auth()->user()->id)->where('status', 1)->paginate(10);
        }
        elseif($slug == 'active'){
            $serviceorder= ServiceOrder::where('seller_id', auth()->user()->id)->where('status', 2)->paginate(10);
        }
        else{
            $serviceorder= ServiceOrder::where('seller_id', auth()->user()->id)->paginate(10);
        }
        
        return view('user.service_order.index', compact('serviceorder'));
    }

    public function status(Request $request, $id)
    {
        $serviceorder= ServiceOrder::where('id', $id)->first();
        $serviceorder->status = $request->status;
        $serviceorder->save();
        return redirect()->back()->with('success', 'Order Status Updated Successfully');
    }

    public function details($id){
        $serviceorder= ServiceOrder::where('id', $id)->first();
        $serviceincludes =  Serviceincludes::where('service_id', $serviceorder->service_id)->get();
        return view('user.service_order.details', compact('serviceorder', 'serviceincludes'));
    }

    public function completerequest($id){
        $serviceorder= ServiceOrder::where('id', $id)->first();
        $serviceorder->order_complete_request = 1;
        $serviceorder->save();
        return redirect()->back()->with('success', 'Order Status Updated Successfully');
    }
}
