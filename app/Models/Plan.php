<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'subtitle',
        'price',
        'plan_type',
        'connect',
        'job',
        'service',
        'status',
    ];

    public function userSubscriptions(){
        return $this->hasMany('App\Models\UserSubscription','planid');
    }

}
