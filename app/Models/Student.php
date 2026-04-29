<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory, BelongsToEcole, SoftDeletes;


    // Notes de l'élève


    protected $fillable = [
        'user_id',
        'matricule',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'email',
        'phone',
        'address',
        'status',
        'photo',
        'ecole_id',
        'est_affecte',
    ];
    private function generateMatricule()
    {
        $year = date('y');
        $month = date('m');
        $prefix = $year . $month;

        $lastStudent = self::withoutGlobalScopes()
            ->where('matricule', 'like', $prefix . '%')
            ->orderBy('matricule', 'desc')
            ->first();

        $lastId = $lastStudent ? intval(substr($lastStudent->matricule, -4)) : 0;
        $newId = $lastId + 1;

        return $prefix . str_pad($newId, 4, '0', STR_PAD_LEFT);
    }
    public static function boot()
    {
        parent::boot();

        self::creating(function ($student) {
            $student->matricule = $student->generateMatricule();
        });
    }

    public function parents()
    {
        return $this->belongsToMany(
            Parents::class,
            'relations',
            'student_id',
            'parent_id'
        )->withPivot('relation')->withTimestamps();
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function classe()
    {
        return $this->hasOneThrough(
            Classe::class,
            Inscription::class,
            'student_id',     // Clé étrangère dans Inscription
            'id',             // Clé locale dans Classe
            'id',             // Clé locale dans Student
            'classe_id'       // Clé étrangère dans Inscription
        );
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function evaluations()
    {
        return $this->belongsToMany(Evaluation::class, 'notes')
            ->withPivot('note')
            ->withTimestamps();
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
