<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Frais_Scolaire extends Model
{
    use BelongsToEcole;
    protected $table = 'frais_scolaires';
    protected $fillable = ['frais_inscription', 'frais_Scolarité', 'niveau_id', 'annee_scolaire_id', 'ecole_id'];

    public function anneeScolaire()
    {
        return $this->belongsTo(Annee_Scolaire::class);
    }
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

}
