<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere_classe extends Model
{
    protected $table = 'matiere_classe';
    protected $fillable = ['matiere_id', 'classe_id', 'coefficient'];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
