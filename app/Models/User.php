<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_blocked', // recuerda agregar este campo en la migración y base de datos
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_blocked' => 'boolean',
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
        return $this->hasMany(Message::class, 'recipient_id');  // corregido aquí
    }

    /**
     * Obtener lista de usuarios a quienes este usuario puede enviar mensajes.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllowedRecipients()
    {
        $role = $this->getRoleNames()->first(); // Obtener primer rol asignado

        if ($role === 'admin') {
            // Admin puede enviar a todos excepto a sí mismo
            return User::where('id', '<>', $this->id)->get();
        }

        if ($role === 'graduate') {
            // Egresado puede enviar a admin y empleadores
            $allowedRoles = ['admin', 'employer'];
        } elseif ($role === 'employer') {
            // Empleador puede enviar a admin y egresados
            $allowedRoles = ['admin', 'graduate'];
        } else {
            // Otros roles: no enviar a nadie
            return collect();
        }

        return User::where('id', '<>', $this->id)
            ->whereHas('roles', function ($query) use ($allowedRoles) {
                $query->whereIn('name', $allowedRoles);
            })->get();
    }
}
