<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = ['name', 'description'];

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function graduates()
    {
        return $this->hasMany(Graduate::class);
    }
}
