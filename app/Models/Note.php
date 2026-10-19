<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Note extends Model
{
     use HasFactory, BelongsToEcole;

    protected $fillable = [
        'evaluation_id',
        'student_id',
        'note',
        'appreciation',
        'ecole_id',
    ];

    protected $casts = [
        'note' => 'float',
    ];

    /* ================= RELATIONS ================= */

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
