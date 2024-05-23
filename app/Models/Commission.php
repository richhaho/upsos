<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;
    protected $fillable = [
        'commission_from',
        'commission_charge',
        'commission_method',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
        
    }
}
