<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcolePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ecole_id',
        'montant',
        'date_paiement',
        'mode_paiement',
        'reference',
        'notes'
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'montant' => 'decimal:2',
    ];

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }
}
