<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToEcole;

class Relation extends Model
{
    use BelongsToEcole;
    protected $fillable = ['student_id', 'parent_id', 'relation', 'ecole_id'];
}
