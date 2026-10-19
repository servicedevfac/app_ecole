<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Facture_lignes extends Model
{
    use BelongsToEcole;
    protected $fillable = [
        'facture_id',
        'frais_scolaire_id',
        'montant',
        'ecole_id',
    ];
}
