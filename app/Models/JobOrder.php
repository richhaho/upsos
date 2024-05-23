<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'seller_id',
        'buyer_id',
        'job_request_id',
        'transaction_no',
        'txnid',
        'price',
        'admin_commission_price',
        'currency_id',
        'currency_sign',
        'currency_code',
        'payment_status',
        'payment_method',
        'order_status',
        'order_type',
        'order_complete_request',
        'created_at',
        'updated_at',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class,'job_id');
    }
}
