<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Presence extends Model
{
    use HasFactory, BelongsToEcole;

    protected $fillable = [
        'student_id',
        'classe_id',
        'emploi_du_temps_id',
        'matiere_id',
        'date',
        'statut',
        'ecole_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function emploiDuTemps()
    {
        return $this->belongsTo(Emploi_du_temps::class, 'emploi_du_temps_id');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
