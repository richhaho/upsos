<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serviceadditional extends Model
{
    use HasFactory;
    protected $fillable = ['seller_id','service_id','additional_service_title','additional_service_price','additional_service_quantity','product_image'];
    public $timestamps = false;

    public function seller()
    {
        return $this->belongsTo('App\Models\user', 'seller_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
