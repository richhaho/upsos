<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'value'
    ];

    protected $casts = [
        'value' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

