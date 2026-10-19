<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Payment extends Model
{
    use BelongsToEcole;
    protected $fillable = [
        'facture_id',
        'montant',
        'date_paiement',
        'mode_paiement',
        'reference',
        'notes',
        'ecole_id',
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }
}
