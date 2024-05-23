<?php

namespace App\Http\Controllers\JobPayment;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\JobOrder;
use App\Models\Jobrequest;
use App\Models\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    protected $gs;
    protected $language;
    protected $user;
    protected $curr;

    public function __construct()
    {

        $this->gs = DB::table('generalsettings')->find(1);
        $this->middleware(function ($request, $next) {
        $this->user = Auth::user();


            if (Session::has('language'))
            {
                $this->language = DB::table('languages')->find(Session::get('language'));
            }
            else
            {
                $this->language = DB::table('languages')->where('is_default','=',1)->first();
            }

            if (Session::has('currency')) {
                $this->curr = DB::table('currencies')->find(Session::get('currency'));
            }
            else {
                $this->curr = DB::table('currencies')->where('is_default','=',1)->first();
            }


            return $next($request);
        });
    }

    public function store(Request $request)
    {

        $uamount= rootAmount(Auth::user()->balance);

        $amount = $request->price;
        
        if ($uamount < $amount) {
           return redirect()->back()->with('error', 'Insufficient Balance. Please deposit money to your wallet.');
        }
        else{
            

        $user = Auth::user();
        
            $jobrequest = Jobrequest::findOrFail($request->id);

            $joborder = new JobOrder();
            $data['job_id'] = $request->job_id;
            $data['seller_id'] = $jobrequest->seller_id;
            $data['buyer_id'] = $jobrequest->buyer_id;
            $data['transaction_no'] = Str::random(3).substr(time(), 6,8).Str::random(3);
            $data['txnid'] = 'Not Available';
            $data['job_request_id'] = $request->id;
            $data['price'] = $request->price/$this->curr->value;
            $data['currency_id'] = $this->curr->id;
            $data['currency_sign'] = $this->curr->sign;
            $data['currency_code'] = $this->curr->name;
            $data['payment_status'] = 'Completed';
            $data['payment_method'] = 'Wallet';
            $data['order_status'] = 'pending';
            $data['order_type'] = $jobrequest->job_type;
            $data['order_complete_request'] = 'No request';
            
            $joborder->fill($data)->save();

            $jobrequest->hired_status = 1;
            $jobrequest->save();

            $user->balance = $uamount - $amount;
            $user->save(); 


            $trans = new Transaction();
            $trans->email = $user->email;
            $trans->amount = $request->price/$this->curr->value;
            $trans->type = "Job Order";
            $trans->profit = "Minus";
            $trans->txnid = "Not Available";
            $trans->user_id = $user->id;
            $trans->save();

            $data = [
                'to' => $user->email,
                'type' => "job order",
                'cname' => $user->name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
                'onumber' => "",
            ];
            $mailer = new GeniusMailer();
            $mailer->sendAutoMail($data);

            return redirect()->route('buyer.jobrequest')->with('success', 'Job Order Placed Successfully.');
            
        
        }
    }
}
