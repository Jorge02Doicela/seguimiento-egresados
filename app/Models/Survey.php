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
        'end_date'
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
}
