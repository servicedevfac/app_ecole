<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Annee_scolaire extends Model
{
    /** @use HasFactory<\Database\Factories\AnneeScolaireFactory> */
    use HasFactory, BelongsToEcole;
    protected $fillable = [
        'annee',
        'date_debut',
        'date_fin',
        'status',
        'ecole_id',
    ];
    public static function active()
    {
        return self::where('status', 'actif')->first();
    }

    public function periodes()
    {
        return $this->hasMany(Periode::class, 'annee_scolaire_id');
    }
}
