<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Parents extends Model
{
    /** @use HasFactory<\Database\Factories\ParentsFactory> */
    use HasFactory, BelongsToEcole;
    protected $fillable = ['user_id', 'nom', 'prenom', 'profession', 'email', 'telephone', 'autre_telephone', 'adresse', 'ecole_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'relations',
            'parent_id',
            'student_id'
        )->withPivot('relation')->withTimestamps();
    }
    

}
