<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Horaire extends Model
{
    use BelongsToEcole;
    protected $table = 'horaires';
    protected $fillable = [
        'heure_debut',
        'heure_fin',
        'type',
        'ecole_id',
    ];
    public function emploiDuTemps(){
        return $this->hasMany(Emploi_du_temps::class, 'horaire_id');
    }


}
