<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    /** @use HasFactory<\Database\Factories\ParentsFactory> */
    use HasFactory;
    protected $fillable = ['nom','prenom','email','telephone','autre_telephone','adresse'];
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
