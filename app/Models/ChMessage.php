<?php

namespace App\Models;

use App\Notifications\NewUnreadChatMessage;
use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;
use Illuminate\Support\Str;

class ChMessage extends Model
{
    use UUID;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
        static::created(function (ChMessage $model) {
            if (!$model->recipient->active_status) {
                $model->recipient->notify(new NewUnreadChatMessage($model));
            }
        });
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
}
