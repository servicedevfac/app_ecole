<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentReportController extends Controller
{
    //
    public function index(Request $request)
    {
        $studentId = $request->query('student_id');
        return view('admin.etudiant.show', compact('studentId'));
    }
}
