<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serviceincludes extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'seller_id',
        'include_service_title',
        'include_service_price',
        'include_service_quantity',
        'image',
        'created_at',
        'updated_at'
    ];

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
