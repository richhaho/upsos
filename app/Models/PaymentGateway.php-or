<?php

namespace App\Models;
use Illuminate\{
    Database\Eloquent\Model
};


class PaymentGateway extends Model
{
    protected $fillable = ['title', 'details', 'subtitle', 'name', 'type', 'information','currency_id'];
    public $timestamps = false;

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency')->withDefault();
    }

    public static function scopeHasGateway($curr)
    {
        return PaymentGateway::where('currency_id', 'like', "%\"{$curr}\"%")->get();
    }

    public function convertAutoData(){
        return  json_decode($this->information,true);
    }

    public function getAutoDataText(){
        $text = $this->convertAutoData();
        return end($text);
    }

    public function showKeyword(){
        $data = $this->keyword == null ? 'other' : $this->keyword;
        return $data;
    }
    public function showForm(){
        $show = '';
        $data = $this->keyword == null ? 'other' : $this->keyword;
        $values = ['cod','voguepay','sslcommerz','flutterwave','razorpay','mollie','paytm','paystack','paypal','instamojo'];
        if (in_array($data, $values)){
            $show = 'no';
        }else{
            $show = 'yes';
        }
        return $show;
    }
    public function showCheckoutLink(){
        $link = '';
        $data = $this->keyword == null ? 'other' : $this->keyword;
        if($data == 'paypal'){
            $link = route('service.paypal.submit');
        }

        else if($data == 'stripe'){
            $link = route('service.stripe.submit');
        }
        else if($data == 'flutterwave'){
            $link = route('service.flutter.submit');
        }
        else if($data == 'authorize.net'){
            $link = route('service.authorize.submit');
        }
        else if($data == 'razorpay'){
            $link = route('service.razorpay.submit');
        }
        else if($data == 'paytm'){
            $link = route('service.paytm.submit');
        }
        else if($data == 'instamojo'){
            $link = route('service.instamojo.submit');
        }
        else if($data == 'paystack'){
            $link = route('service.paystack.submit');
        }
        elseif ($data == 'mercadopago'){
            $link = route('service.mercadopago.submit');
        }
        elseif( $data == 'manual'){
            $link = route('service.manual.submit');
        }
       
        

        return $link;
    }





 

}