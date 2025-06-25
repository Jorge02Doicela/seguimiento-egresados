<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graduate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cohort_year',
        'gender',
        'company',
        'position',
        'salary',
        'sector',
        'portfolio_url',
        'cv_path',
        'country',
        'city',
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con Skills (muchos a muchos)
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'graduate_skill', 'graduate_id', 'skill_id');
    }
}
