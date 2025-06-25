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
        'scale_max',
    ];

    protected $casts = [
        'options' => 'array', // para manejar el JSON automáticamente como array
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
