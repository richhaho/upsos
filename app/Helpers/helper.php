<?php

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Generalsetting;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\EmailTemplate;
use App\Models\Partner;
use App\Models\Review;
use App\Models\Service;
use App\Models\Serviceincludes;
use App\Models\Withdraw;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if(!function_exists('globalCurrency')){
        function globalCurrency(){
            $currency = Session::get('currency') ?  DB::table('currencies')->where('id','=',Session::get('currency'))->first() : DB::table('currencies')->where('is_default','=',1)->first();
            return $currency;
        }
    }

    if(!function_exists('defaultCurr')){
        function defaultCurr(){
            return Currency::where('is_default','=',1)->first();
        }
    }

    
    if(!function_exists('showPrice')){
        function showPrice($price){
          $gs = Generalsetting::first();
          $currency = globalCurrency();
          
          $price = round(($price) * $currency->value,2);
          if($gs->currency_format == 0){
              return $currency->sign.' '.$price;
          }
          else{
              return $price.' '.$currency->sign;
          }
      }
    }

    if(!function_exists('showAdminPrice')){
        function showAdminPrice($price){
          $gs = Generalsetting::first();
          $currency = defaultCurr();
          
          $price = round(($price) * $currency->value,2);
          if($gs->currency_format == 0){
              return $currency->sign.' '.$price;
          }
          else{
              return $price.' '.$currency->sign;
          }
      }
    }

    if(!function_exists('showAdmininputPrice')){
        function showAdmininputPrice($price){
          $gs = Generalsetting::first();
          $currency = defaultCurr();
          
          $price = round(($price) * $currency->value);
          if($gs->currency_format == 0){
              return $price;
          }
          else{
              return $price;
          }
      }
    }

    if(!function_exists('showAmount')){
        function showAmount($price){
            $gs = Generalsetting::first();
            $currency = globalCurrency();

            $price = round(($price) * $currency->value);
            if($gs->currency_format == 0){
                return $currency->sign.' '. $price;
            }
            else{
                return $price.' '. $currency->sign;
            }
        }
    }

    if(!function_exists('showNameAmount')){
        function showNameAmount($amount){
            $gs = Generalsetting::first();
            $currency = globalCurrency();

            $price = round(($amount) * $currency->value,2);
            if($gs->currency_format == 0){
                return $currency->name.' '. $price;
            }
            else{
                return $price.' '. $currency->name;
            }
        }
    }

    if(!function_exists('rootAmount')){
        function rootAmount($price){
            $gs = Generalsetting::first();
            $currency = globalCurrency();
            $price = round(($price) * $currency->value);
            return $price;
        }
    }


    if(!function_exists('convertedPrice')){
        function convertedPrice($price){
            $currency = DB::table('currencies')->where('is_default','=',1)->first();
            $gs = Generalsetting::first();

            $price = round(($price) * $currency->value,2);
            if($gs->currency_format == 0){
                return $currency->sign. $price;
            }
            else{
                return $price. $currency->sign;
            }
        }
    }

    

    if(!function_exists('baseCurrencyAmount')){
        function baseCurrencyAmount($amount){
            $currency = globalCurrency();
            return round($amount/$currency->value,2);
        }
    }

    if(!function_exists('ratings')){
        function ratings($id){
            $rating = Review::where('service_id','=',$id)->avg('rating'); 
            return $rating;
        }
    }



    if(!function_exists('commissionCalculate')){
        function commissionCalculate($amount){
            $gs = Generalsetting::first();
            $commission = $gs->commission_type;
            if($commission == 0){
                $commission = $gs->commission_price;
            }
            else{
                $commission = ($gs->commission_price/100) * $amount;

            }
            return $commission;
            
        }
    }

    if(!function_exists('servicePrice')){
        function servicePrice($id){
            $service= Service::findOrFail($id);
            $price=$service->price;
            return $price;
        }
    }


    if(!function_exists('getWithdraws')){
        function getWithdraws(){
            return Withdraw::orderBy('id','desc')->limit(10)->get();
        }
    }

    if(!function_exists('getDeposits')){
        function getDeposits(){
            return Deposit::orderBy('id','desc')->limit(10)->get();
        }
    }

    if(!function_exists('getPartners')){
        function getPartners(){
            return Partner::orderBy('id','desc')->get();
        }
    }


    if(!function_exists('getDateMonth')){
        function getDateMonth($date){
            return Carbon::parse($date)->format('M');
        }
    }

    if(!function_exists('getDateDay')){
        function getDateDay($date){
            return Carbon::parse($date)->format('d');
        }
    }

    if(!function_exists('getCryptoRate')){
        function getCryptoRate($currency){
            $gs = GeneralSetting::first();
            $url = 'https://min-api.cryptocompare.com/data/price?fsym='.$currency.'&tsyms=USD&api_key='. $gs->crypto_rate_apikey;
            $basedCurrencyJsonAmount = file_get_contents($url);

            $based = json_decode($basedCurrencyJsonAmount, true);
            $rate = $based['USD'];
            return $rate;
        }
    }

    if(!function_exists('getAdmin')){
        function getAdmin(){
            return Admin::first();
        }
    }

    if(!function_exists('offlineservicePrice')){
        function offlineservicePrice($id){
            $allprices= DB::table('serviceincludes')->where('service_id','=',$id)->get();
            $price=0;
            foreach($allprices as $allprice){
                $price=$price+$allprice->include_service_price;
            }
            return $price;
        
        }
    }

    if(!function_exists('prefix')){
        function prefix(){
            $gs = GeneralSetting::first();
            return $gs->prefix != NULL ? $gs->prefix : 'admin';
        }
    }

    if(!function_exists('fileName')){
        function fileName($file){
            return Str::random(8).time().'.'.$file->getClientOriginalExtension();
        }
    }

    if(!function_exists('upload')){
        function upload($name,$file,$oldname)
        {
            $file->move('assets/images',$name);
            if($oldname != null)
            {
                if (file_exists(public_path().'/assets/images/'.$oldname)) {
                    unlink(public_path().'/assets/images/'.$oldname);
                }
            }
        }
    }




  function email($data){

    $gs = Generalsetting::first();

        if ($gs->is_smtp != 1) {
            $headers = "From: $gs->sitename <$gs->email_from> \r\n";
            $headers .= "Reply-To: $gs->sitename <$gs->email_from> \r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";
            mail($data['email'], $data['subject'], $data['message'], $headers);
        }
        else {
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
                $mail->addAddress($data['email'], $data['name']);
                $mail->addReplyTo($gs->from_email, $gs->from_name);
                $mail->isHTML(true);
                $mail->Subject = $data['subject'];
                $mail->Body    = $data['message'];
                $mail->send();
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }
    }

    if (!function_exists('isOnlineService')) {
        function isOnlineService()
        {
            // Add user online service status
            $online_service_status = false;
            if (\Auth::guard('web')->check()) {
                $online_service_status = \Auth::guard('web')->user()?->online_service_status;
            } else {
                $online_service_status = session('online_service_status');
            }

            return $online_service_status;
        }
    }
