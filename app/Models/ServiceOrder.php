<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = ['service_id','seller_id','buyer_id', 'name','email','phone','address','details','country_id','city_id','area_id','date','schedule','package_fee','include','quantity','additional_service_cost','tax','total','commission_type','commission_charge','commission_amount','payment_method','payment_status','status','is_online','transaction_no','txnid','order_complete_request','currency_sign','currency_value','created_at','updated_at','schedule_status','charge_id'];

    public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }

    public function seller(){
        return $this->belongsTo(User::class,'seller_id');
    }

    public function buyer(){
        return $this->belongsTo(User::class,'buyer_id');
    }


}
