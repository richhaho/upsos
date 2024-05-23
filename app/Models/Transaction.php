<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = ['user_id',  'amount', 'txnid', 'type'];
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }
}
