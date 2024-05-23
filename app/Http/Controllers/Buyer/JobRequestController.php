<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\BuyerSellerMessage;
use App\Models\JobOrder;
use App\Models\Jobrequest;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    public function index()
    {
        $jobrequests = Jobrequest::where('buyer_id',auth()->id())->where('hired_status',0)->orderBy('id','DESC')->paginate(10);
        return view('buyer.jobrequest.index', compact('jobrequests'));
    }

    public function show($id)
    {
        $data['jobrequest'] = Jobrequest::findOrFail($id);
        $data['gateways']=PaymentGateway::get();
        $paystackData = PaymentGateway::whereKeyword('paystack')->first();
        $data['paystack'] = $paystackData->convertAutoData();
        return view('buyer.jobrequest.show', $data);
    }

    
    public function delete($id)
    {
        $jobrequest = Jobrequest::findOrFail($id);
        $joborder = JobOrder::where('job_request_id',$id)->first();
        if($joborder->order_status == 'pending'){
            return redirect()->back()->with('error', 'You can not delete this job request because it is already hired by you.');
        }
       $message= BuyerSellerMessage::where('job_id',$jobrequest->job_id)->get();
         foreach($message as $msg){
              $msg->delete();
            }
        $jobrequest->delete();
        return redirect()->back()->with('success', 'Job Request Deleted Successfully');
    }

    




}
