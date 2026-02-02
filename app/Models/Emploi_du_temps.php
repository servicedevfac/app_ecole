<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emploi_du_temps extends Model
{
    protected $table = 'emploi_du_temps';
    protected $fillable = [
        'enseignant_id',
        'classe_id',
        'matiere_id',
        'horaire_id',
        'annee_scolaire_id',
        'jours_id',
      
    ];
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function anneeScolaire()
    {
        return $this->belongsTo(Annee_scolaire::class);
    }
    public function enseignant(){
        return $this->belongsTo(Enseignant::class);
    }

    public function matiere(){
        return $this->belongsTo(Matiere::class);
    }
    public function horaire()
    {
        return $this->belongsTo(Horaire::class, 'horaire_id');
    }
    public function jour()
    {
        return $this->belongsTo(Jour::class, 'jours_id');
    }
}
