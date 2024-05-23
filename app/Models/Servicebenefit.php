<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicebenefit extends Model
{
    use HasFactory;
    protected $fillable = ['seller_id','service_id','benefits'];
    public $timestamps = false;

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
