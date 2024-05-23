<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobrequest extends Model
{
    use HasFactory;

    protected $fillable = [
       
        'job_id',
        'buyer_id',
        'seller_id',
        'job_type',
        'job_title',
        'seller_offer',
        'buyer_offer',
        'job_request_id',
        'description',
        'hired_status',
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
