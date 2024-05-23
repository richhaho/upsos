<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\PaymentGateway;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public $gs;
    public  $allusers = [];
    public $referral_ids = [];

    public function __construct()
    {
        $this->middleware('auth');
        $this->gs = Generalsetting::findOrFail(1);
    }

    public function plans(){
        $data['plans'] = Plan::whereStatus(1)->orderBy('id','desc')->get();
        return view('user.plan.plans',$data);
    }
    public function userSubscription($slug){
        $plan = Plan::where('subtitle', $slug)->firstOrFail();
        $user = Auth::user();
        $gateways= PaymentGateway::where('status',1)->get();
        return view('user.plan.checkout',compact('plan','user','gateways'));
    }
    
}
