<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relación muchos a muchos con Graduate
    public function graduates()
    {
        return $this->belongsToMany(Graduate::class, 'graduate_skill', 'skill_id', 'graduate_id');
    }
}
