<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['title', 'description'];

    // Una encuesta tiene muchas preguntas
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
