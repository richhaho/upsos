<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerSellerMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'buyer_id',
        'user_type',
        'work_type',
        'job_id',
        'service_id',
        'message',
        'attachment',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;

    public function seller()
    {
        return $this->belongsTo('App\Models\User', 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo('App\Models\User', 'buyer_id');
    }
}
