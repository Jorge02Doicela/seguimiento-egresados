<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'content',
        'attachment_path',
        'read_at',
    ];

    // Relaciones
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function getIsReadAttribute()
    {
        return !is_null($this->read_at);
    }
}
