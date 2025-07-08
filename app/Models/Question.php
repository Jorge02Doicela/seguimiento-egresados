<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'survey_id',
        'question_text',
        'type',
        'options',
        'scale_min',
        'scale_max'
    ];

    protected $casts = [
        'options' => 'array',
    ];

    // Relación con Survey (pertenece a una encuesta)
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    // Relación con Answer (tiene muchas respuestas)
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
