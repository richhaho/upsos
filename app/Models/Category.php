<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'color',
        'photo',
        'status',
    ];

    protected $appends = [
        'is_online_service'
    ];

    public $timestamp = false;

    public function subcategories(){
        return $this->hasMany( 'App\Models\Subcategory', 'category_id' );
    }

    public function jobs(){
        return $this->hasMany( 'App\Models\Job', 'category_id' );
    }

    public function services(){
        return $this->hasMany( 'App\Models\Service', 'category_id' );
    }

    public function getIsOnlineServiceAttribute()
    {
        return $this->slug == 'online-services' ? true : false;
    }
}
