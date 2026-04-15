<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'type',
        'status',
        'reply',
        'replied_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
