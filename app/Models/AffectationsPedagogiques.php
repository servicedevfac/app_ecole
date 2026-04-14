<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class AffectationsPedagogiques extends Model
{
    use BelongsToEcole;
    protected $table = 'affectations_pedagogiques';

    protected $fillable = [
        'enseignant_id',
        'matiere_id',
        'classe_id',
        'annee_scolaire_id',
        'ecole_id',
    ];
        public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function anneeScolaire()
    {
        return $this->belongsTo(Annee_scolaire::class);
    }
}
