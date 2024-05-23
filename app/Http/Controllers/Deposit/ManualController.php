<?php

namespace App\Http\Controllers\Deposit;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Deposit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\Generalsetting;
use Illuminate\Support\Facades\Auth;

class ManualController extends Controller
{
    public $gs;
    public function __construct()
    {
        $this->gs = Generalsetting::findOrFail(1);
    }
    public function store(Request $request){

        $currency = Currency::where('id',$request->currency_id)->first();
        $amountToAdd = $request->amount/$currency->value;

        $deposit = new Deposit();
        $deposit['deposit_number'] = Str::random(12);
        $deposit['user_id'] = auth()->id();
        $deposit['currency_id'] = $request->currency_id;
        $deposit['amount'] = $amountToAdd;
        $deposit['method'] = $request->method;
        $deposit['txnid'] = $request->txn_id4;
        $deposit['status'] = "pending";
        $deposit->save();


        $gs =  Generalsetting::findOrFail(1);
        $user = auth()->user();

        $to = $user->email;
        $subject = 'Deposit';
        $msg = "Dear Customer,<br> Your deposit in process.";

        if($this->gs->is_smtp == 1)
        {

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = $this->gs->smtp_host;
                $mail->SMTPAuth   = true;
                $mail->Username   = $this->gs->smtp_user;
                $mail->Password   = $this->gs->smtp_pass;
                if ($this->gs->smtp_encryption == 'ssl') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                } else {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                }
                $mail->Port       = $this->gs->smtp_port;
                $mail->CharSet = 'UTF-8';
                $mail->setFrom($this->gs->from_email, $this->gs->from_name);
                $mail->addAddress($user->email, $user->name);
                $mail->addReplyTo($this->gs->from_email, $this->gs->from_name);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $msg;
                $mail->send();
            } catch (Exception $e) {

            }
        }
        else
        {
            $headers = "From: ".$this->gs->from_name."<".$this->gs->from_email.">";
            mail($to,$subject,$msg,$headers);
        }

        if(Auth::user()->is_seller == 1)
        {
            return redirect()->route('user.deposit.create')->with('success','Deposit amount '.$request->amount.' (USD) successfully!');
        }
        else{
            return redirect()->route('buyer.deposit.create')->with('success','Deposit amount '.$request->amount.' (USD) successfully!');
        }
    }
}
