<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Parents;
use App\Models\Student;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display a dashboard.
     */
    public function index()
    {   
        $students = Student::all();
        $maleStudents = Student::where('sexe', 'M')->count();
        $femaleStudents = Student::where('sexe', 'F')->count();
        $teachers = Enseignant::all();
        $parents = Parents::all();
        $enseignants = Enseignant::count();

        return view('dashboard', compact('students','teachers','enseignants','maleStudents','femaleStudents','parents'));

    }
}
