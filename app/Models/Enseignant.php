<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
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

       
    ];
    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'enseignant_id');
    }
  

}
