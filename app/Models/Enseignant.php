<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToEcole;

use Illuminate\Database\Eloquent\SoftDeletes;

class Enseignant extends Model
{
    use HasFactory, BelongsToEcole, SoftDeletes;
    protected $table = 'enseignants';
    protected $primaryKey = 'id';
    public $timestamps = true;//si on utilise les timestamps created_at et updated_at
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'telephone',
        'email',
        'specialite',
        'statut',
        'ecole_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function affectations()
    {
        return $this->hasMany(AffectationsPedagogiques::class, 'enseignant_id');
    }
    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'enseignant_id');
    }



}
