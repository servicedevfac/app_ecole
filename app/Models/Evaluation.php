<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToEcole;



class Evaluation extends Model
{
    use HasFactory, BelongsToEcole;
    protected $fillable = [
        'classe_id',
        'matiere_id',
        'enseignant_id',
        'coefficient',
        'type',
        'note_max',
        'statut',
        'date_evaluation',
        'libelle',
        'periode_id',
        'ecole_id',
    ];

    /* ================= RELATIONS ================= */

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /* ================= SCOPES ================= */

    public function scopeValidees($query)
    {
        return $query->where('statut', 'validee');
    }

    /* ================= HELPERS ================= */

    public function estArchivee(): bool
    {
        return $this->periode->anneeScolaire->status === 'archived';
    }
}
