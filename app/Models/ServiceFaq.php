<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFaq extends Model
{
    use HasFactory;
    protected $fillable = ['seller_id','service_id','faq_title','faq_detail'];
    public $timestamps = false;


    public function service(){
        return $this->belongsTo(Service::class);
    }
}
