<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Types_frais extends Model
{
    use BelongsToEcole;
    protected $table = 'types_frais';
    protected $fillable = ['nom', 'description', 'ecole_id'];
    public function fraisScolaires()
    {
        return $this->hasMany(Frais_Scolaire::class);
    }
}
