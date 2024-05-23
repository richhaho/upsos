<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    protected $fillable = [
        'tax',
        'country_id',
        'status',
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
