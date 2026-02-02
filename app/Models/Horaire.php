<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    protected $table = 'horaires';
    protected $fillable = [
        'heure_debut',
        'heure_fin',
        'type',
    ];
    public function emploiDuTemps(){
        return $this->hasMany(Emploi_du_temps::class, 'horaire_id');
    }


}
