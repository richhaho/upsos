<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\AdminUserConversation;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data['user'] = Auth::user();
        $data['transactions'] = Transaction::whereUserId(auth()->id())->orderBy('id','desc')->limit(5)->get();
        $data['total_payouts'] = Withdraw::whereUserId(auth()->id())->whereStatus('completed')->sum('amount');
        $data['total_deposits'] = Deposit::whereUserId(auth()->id())->whereStatus('complete')->sum('amount');
        $data['total_transactions'] = Transaction::whereUserId(auth()->id())->sum('amount');
        $data['total_tickets'] = AdminUserConversation::whereUserId(auth()->id())->count();

        return view('buyer.dashboard',$data);
    }

    public function loadpayment($slug1,$slug2)
    {
        $data['payment'] = $slug1;
        $data['pay_id'] = $slug2;
        $data['gateway'] = '';
        if($data['pay_id'] != 0) {
            $data['gateway'] = PaymentGateway::findOrFail($data['pay_id']);
        }
        return view('load.payment-user',$data);
    }
}
