<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Graduate;
use App\Models\Employer;
use App\Models\Answer;
use App\Models\Message;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relaciones

    public function graduate()
    {
        return $this->hasOne(Graduate::class);
    }

    public function employer()
    {
        return $this->hasOne(Employer::class);
    }

    // Resumen: una sola relación para perfil egresado
    public function graduateProfile()
    {
        return $this->hasOne(Graduate::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // ¡Importante! No definas aquí la función notifications()
    // El trait Notifiable ya define la relación con la tabla 'notifications'
}
