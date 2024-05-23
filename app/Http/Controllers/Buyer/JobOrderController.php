<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Generalsetting;
use App\Models\JobOrder;
use App\Models\User;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{
    //
    public function allorder(){
        $orders = JobOrder::where('buyer_id',auth()->id())->orderBy('id','DESC')->paginate(10);
        return view('buyer.joborder.allorder', compact('orders'));
    }

    public function store($id){
        

        $joborder = JobOrder::findOrFail($id);
        $commission = new Commission();
        $gs = Generalsetting::findOrFail(1);
 
        $commission->commision_from= 'seller';
        $commission->commission_method= 'joborder';
        if($gs->commission_type == 1){
            $commission->commision_charge = ($joborder->price * $gs->commission_price) / 100;
        }else{
            $commission->commision_charge = $gs->commission;
        }

        $commission->save();
        $user= User::findOrFail($joborder->seller_id);
        $user->balance = $user->balance + ($joborder->price - $commission->commision_charge);
       
        $user->save();

        $joborder->update([
            'order_complete_request' => 'completed',
            'order_status' => 'completed',
            'admin_commission_price' => $commission->commision_charge,
        ]);
        return redirect()->back()->with('success', 'Order Approved!');

    }
    public function details(Request $request, $id){
        $data['data'] = JobOrder::findOrFail($id);

        return view('buyer.joborder.details',$data);
    }
    
}
