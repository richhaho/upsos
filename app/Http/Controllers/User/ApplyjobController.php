<?php

namespace App\Http\Controllers\User;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Job;
use App\Models\Jobrequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplyjobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('seller');
    }

    public function apply(Request $request)
    {
       
        $job = Job::findOrFail($request->job_id);
        $user = Auth::user();
        $jobcount = Jobrequest::where('seller_id','=',$user->id)->count();

        if(Carbon::now() > $user->plan_expiredate){
            return response()->json(array('errors' => [0 => 'Your subscription has been expired']));
        }

        if($jobcount >= $user->job_limit){
            return response()->json(array('errors' => [0 => 'You have reached your job limit']));
        }
        if($job->budget > $request->seller_offer){
            return response()->json(array('errors' => [0 => 'Your offer must be greater than or equal to the buyer offer.']));
        }
        $jobrequest= new Jobrequest();
        $jobrequest->job_id = $job->id;
        $jobrequest->buyer_id = $job->buyer_id;
        $jobrequest->seller_id = $user->id;
        $jobrequest->job_type = $job->is_job_online;
        $jobrequest->job_title = $job->job_title;
        $jobrequest->description = $job->description;
        $jobrequest->seller_offer= baseCurrencyAmount($request->seller_offer);
        $jobrequest->buyer_offer= $job->budget;
        $jobrequest->hired_status= 0;
        $jobrequest->save();

        $gs = Generalsetting::findOrFail(1);
        $subject = "Email From Of ".Auth::user()->name;
        $to = $job->buyer->email;
        $name = Auth::user()->name;
        $from = Auth::user()->email;
        $message= $name.'Apply You Job'.$job->job_title.'Please Check Your Job Request';
        $msg = "Name: ".$name."\nEmail: ".$from."\nMessage: ".$message;
        if($gs->is_smtp)
        {

         
        $data = [
            'to' => $to,
            'subject' => $subject,
            'body' => $msg,
        ];

        $mailer = new GeniusMailer();
        $mailer->sendCustomMail($data);
        
        }
        else
        {
        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
        mail($to,$subject,$msg,$headers);
        }

        return response()->json(['success' => 'Job request sent successfully.']);
    }

    public function alljobrequest(){
        $user = Auth::user();
        $jobrequests = Jobrequest::where('seller_id', $user->id)->where('hired_status',0)->paginate();
        return view('user.jobrequest.alljobrequest', compact('jobrequests'));
    }

}
