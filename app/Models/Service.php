<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['category_id','subcategory_id','seller_id','service_country_id','service_city_id','service_area_id','title','slug'
        ,'description','image','image_gallery','video','status','is_service_on','price','online_service_price','delivery_days','revision','is_service_online','tax','view','sold_count','featured','created_at','updated_at','is_best','is_popular','is_trending','is_featured','is_new'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'service_subcategory', 'service_id', 'subcategory_id');
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\User', 'seller_id')->withDefault([
            'email' => 'Deleted User',

        ]);
    }

    public function benefits()
    {
        return $this->hasMany('App\Models\Servicebenefit');
    }

    public function includes()
    {
        return $this->hasMany('App\Models\Serviceincludes');
    }

    public function additionals()
    {
        return $this->hasMany('App\Models\Serviceadditional');
    }

    public function country(){
        return $this->belongsTo('App\Models\Country','service_country_id');
    }

    public function city(){
        return $this->belongsTo('App\Models\City','service_city_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review','service_id');
    }

    public function faqs()
    {
        return $this->hasMany('App\Models\ServiceFaq','service_id');
    }

    public function serviceorders() {
        return $this->hasMany('App\Models\ServiceOrder','service_id');
    }
}
