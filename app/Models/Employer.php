<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'user_id',
        'company_name',
        'contact_name',
        'ruc',
        'phone',
        'address',
        'company_email',    // agregado
        'website',
        'sector',
        'country',
        'city',
        'is_verified',
    ];

    // Relación inversa: Un empleador pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
