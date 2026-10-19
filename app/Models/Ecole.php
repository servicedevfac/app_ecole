<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ecole extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'email',
        'telephone',
        'adresse',
        'logo',
        'plan',
        'limite_etudiants',
        'is_active',
        'stripe_id',
        'trial_ends_at',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'trial_ends_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ecole) {
            $ecole->slug = $ecole->slug ?? Str::slug($ecole->nom);
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Les utilisateurs appartenant à cette école.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Les étudiants inscrits dans cette école.
     */
    public function etudiants()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Les classes de cette école.
     */
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

    /**
     * Les matières enseignées dans cette école.
     */
    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }

    /**
     * Les inscriptions enregistrées dans cette école.
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    /**
     * Les enseignants rattachés à cette école.
     */
    public function enseignants()
    {
        return $this->hasMany(Enseignant::class);
    }

    /**
     * Les factures émises par cette école.
     */
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }

    public function ecolePayments()
    {
        return $this->hasMany(EcolePayment::class, 'ecole_id');
    }
}
