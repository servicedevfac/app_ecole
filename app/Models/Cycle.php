<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    /** @use HasFactory<\Database\Factories\CycleFactory> */
    use HasFactory;
    protected $fillable = ['nom'];
    public function niveaux()
    {
        return $this->hasMany(\App\Models\Niveau::class);
    }

    public function inscriptions()
    {
        return $this->hasManyThrough(
            Inscription::class,
            Niveau::class,
            'cycle_id',
            'niveau_id',
            'id',
            'id'
        );
    }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Inscription::class,
            'cycle_id',       // Clé étrangère dans Inscription
            'student_id',     // Clé étrangère dans Inscription
            'id',             // Clé locale dans Cycle
            'id'              // Clé locale dans Student
        );
    }

    public function matieres()
    {
        return $this->belongsToMany(Matiere::class)
                    ->withPivot('coefficient')
                    ->withTimestamps();
    } 

}
