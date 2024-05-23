<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable=['transaction_no','txnid','user_id','planid','currency_id','method','amount','notify_id','connect','plan_type','payment_status','charge_id','created_at'];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\Models\User')->withDefault();
    }

    public function plan(){
        return $this->belongsTo('App\Models\Plan','planid')->withDefault();
    }
}
