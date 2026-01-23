<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $fillable = ['nom', 'code', 'classe_id'];



     public function classes()
    {
        return $this->belongsToMany(
                    Classe::class,
                    'matiere_classe',
                    'matiere_id',
                    'classe_id'
                )
                    ->withPivot('coefficient')
                    ->withTimestamps();
    }
  
}


