<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',      // 'email' or 'sms'
        'message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
