<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Matiere_classe extends Model
{
    use BelongsToEcole;
    protected $table = 'matiere_classe';
    protected $fillable = ['matiere_id', 'classe_id', 'coefficient', 'ecole_id'];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
