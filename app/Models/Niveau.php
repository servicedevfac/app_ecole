<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $fillable = ['cycle_id', 'name']; 
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }
    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function inscriptions()
    {
        return $this->hasManyThrough(
            Inscription::class,
            Classe::class,
            'niveau_id',
            'classe_id',
            'id',
            'id'
        );
    }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Inscription::class,
            'niveau_id',      // Clé étrangère dans Inscription
            'student_id',     // Clé étrangère dans Inscription
            'id',             // Clé locale dans Niveau
            'id'              // Clé locale dans Student
        );
    }
}
