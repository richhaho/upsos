<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\User;
use App\Classes\GeniusMailer;
use App\Models\BankPlan;
use App\Models\Country;
use App\Models\Notification;
use App\Models\ReferralBonus;
use App\Models\Transaction;
use App\Models\UserSubscription;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Input;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Str;
use Validator;
use Session;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegisterForm(){
        $data['countries'] = Country::where('status',1)->get();
        return view('user.register',$data);
    }

    public function register(Request $request)
    {
        $value = session('captcha_string');
        if ($request->codes != $value){
            return response()->json(array('errors' => [ 0 => 'Please enter Correct Capcha Code.' ]));
        }

        $rules = [
            'username' => 'required|alpha_dash|min:5|unique:users',
            'email' => 'required|email|max:255|unique:users',
            //'phone' => 'required|min:6',
            'password' => 'required|confirmed',
			'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $gs = Generalsetting::findOrFail(1);

        $user = new User;
        $input = $request->all();

        $input['password'] = bcrypt($request['password']);
        $token = md5(time().$request->name.$request->email);
        $input['verification_link'] = $token;
        $input['affilate_code'] = md5($request->name.$request->email);
        $input['is_seller'] = $request->is_seller;
        $user->fill($input)->save();

        if($gs->is_verification_email == 1)
        {
            $verificationLink = "<a href=".url('user/register/verify/'.$token).">Simply click here to verify. </a>";
            $to = $request->email;
            $subject = 'Verify your email address.';
            $msg = "Dear Customer,<br> We noticed that you need to verify your email address.".$verificationLink;

            if($gs->is_smtp == 1)
            {

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = $gs->smtp_host;
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $gs->smtp_user;
                    $mail->Password   = $gs->smtp_pass;
                    if ($gs->smtp_encryption == 'ssl') {
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    } else {
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    }
                    $mail->Port       = $gs->smtp_port;
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom($gs->from_email, $gs->from_name);
                    $mail->addAddress($user->email, $user->name);
                    $mail->addReplyTo($gs->from_email, $gs->from_name);
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body    = $msg;
                    $mail->send();
                } catch (Exception $e) {

                }
            }
            else
            {
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                mail($to,$subject,$msg,$headers);
            }
            return response()->json('We need to verify your email address. We have sent an email to '.$to.' to verify your email address. Please click link in that email to continue.');
        }
        else {

           

            

            $user->email_verified = 'Yes';
            $user->update();

            if($gs->is_smtp == 1)
            {
                $data = [
                    'to' => $user->email,
                    'type' => "welcome",
                    'cname' => $user->name,
                    'oamount' => "",
                    'aname' => "",
                    'aemail' => "",
                    'wtitle' => "",
                    "onumber" => "",
                ];

                $mailer = new GeniusMailer();
                $mailer->sendAutoMail($data);
            }
            else
            {
               $to = $user->email;
               $subject = "Welcome to our website";
               $msg = "Hello ".$user->name."!\nYour registration successfully completed.\nThank you.";
               $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
               mail($to,$subject,$msg,$headers);
            }

            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->save();
            Auth::guard('web')->login($user);

            return response()->json(1);
        }

    }

    public function token($token)
    {
            $gs = Generalsetting::findOrFail(1);
            if($gs->is_verification_email == 1)
            {
                $user = User::where('verification_link','=',$token)->first();
                if(isset($user))
                {
                    $user->email_verified = 'Yes';
                    $user->update();

                           


                    $notification = new Notification;
                    $notification->user_id = $user->id;
                    $notification->save();

                    if($gs->is_smtp == 1)
                    {
                        $data = [
                            'to' => $user->email,
                            'type' => "welcome",
                            'cname' => $user->name,
                            'oamount' => "",
                            'aname' => "",
                            'aemail' => "",
                            'wtitle' => "",
                            "onumber" => "",
                        ];

                        $mailer = new GeniusMailer();
                        $mailer->sendAutoMail($data);
                    }
                    else
                    {
                       $to = $user->email;
                       $subject = "Welcome to our website";
                       $msg = "Hello ".$user->name."!\nYour registration successfully completed.\nThank you.";
                       $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                       mail($to,$subject,$msg,$headers);
                    }
                    
                    Auth::guard('web')->login($user);

                    if($user->is_seller == 1)
                    {
                        return redirect()->route('user.dashboard')->with('success','Email Verified Successfully');
                    }
                    else {
                        return redirect()->route('buyer.dashboard')->with('success','Email Verified Successfully');
                    }

                   
                }
            }
            else {
                return redirect()->back();
            }
    }
}
