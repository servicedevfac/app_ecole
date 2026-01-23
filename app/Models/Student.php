<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

  
    // Notes de l'élève
  

    protected $fillable = [
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
    ];
    private function generateMatricule()
    {
        $year = date('y');
        $month = date('m');
        $prefix = $year . $month;

        $lastStudent = self::where('matricule', 'like', $prefix . '%')
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
}
