<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_id',
        'title',
        'status',
        'tax'
    ];
    public $timestamps = false;

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function areas(){
        return $this->hasMany(Area::class);
    }
}
