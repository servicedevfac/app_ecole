<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annee_scolaire extends Model
{
    /** @use HasFactory<\Database\Factories\AnneeScolaireFactory> */
    use HasFactory;
    protected $fillable = [
        'annee',
        'date_debut',
        'date_fin',
        'status',
    ];
    public static function active()
    {
        return self::where('status', 'active')->first();
    }
}
