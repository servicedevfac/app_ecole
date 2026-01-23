<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


  
class Classe extends Model
{
    /** @use HasFactory<\Database\Factories\ClasseFactory> */
    use HasFactory;
    protected $fillable = ['nom','niveau_id'];
    public function niveau()
    {
        return $this->belongsTo(\App\Models\Niveau::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'inscriptions',
            'classe_id',
            'student_id'
        );
    }


    public function matieres()
    {
        return $this->belongsToMany(
                    Matiere::class,
                    'matiere_classe',
                    'classe_id',
                    'matiere_id'
                )
                    ->withPivot('coefficient')
                    ->withTimestamps();
    }

}
