<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class StudentDocument extends Model
{
    use HasFactory, BelongsToEcole;

    protected $fillable = [
        'student_id',
        'titre',
        'type',
        'file_path',
        'file_type',
        'file_size',
        'ecole_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
