<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'career_id',
        'title',
        'description',
        'is_active',
        'start_date',
        'end_date',
    ];

    // Indicamos que estos campos son fechas y se castean a objetos Carbon automáticamente
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relación con Career (pertenece a una carrera)
    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    // Relación con Question (tiene muchas preguntas)
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Accesor para saber si la encuesta está activa según flag y fechas.
     */
    public function getIsCurrentlyActiveAttribute()
    {
        $now = now();
        return $this->is_active
            && (!$this->start_date || $this->start_date <= $now)
            && (!$this->end_date || $this->end_date >= $now);
    }
}
