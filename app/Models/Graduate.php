<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Crypt;

class Graduate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'career_id',
        'cohort_year',
        'gender',
        'is_working',
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

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    // Encriptar y desencriptar salary
    protected function salary(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Crypt::decryptString($value) : null,
            set: fn($value) => $value ? Crypt::encryptString($value) : null,
        );
    }
}
