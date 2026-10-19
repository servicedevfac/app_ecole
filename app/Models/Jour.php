<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jour extends Model
{
    protected $fillable = ['jours'];
    
    public function emploiDuTemps()
    {
        return $this->hasMany(Emploi_du_temps::class, 'jours_id');
    }
}
