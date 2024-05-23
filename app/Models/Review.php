<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['buyer_id','service_id','review','rating'];
    public $timestamps = false;

    public function service()
    {
    return $this->belongsTo('App\Models\Service');
    }

    public function buyer()
    {
    return $this->belongsTo('App\Models\User', 'buyer_id');
    }


}



