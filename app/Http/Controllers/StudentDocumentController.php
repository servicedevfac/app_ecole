<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\StudentDocument;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    /**
     *  Liste des documents d'un élève
     */
    public function index($student_id)
    {
        $student = Student::findOrFail($student_id);
        $documents = $student->documents;
        return view('admin.etudiant.documents.index', compact('student', 'documents'));
    }

    /**
     *  Upload
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'titre' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120', // 5MB max
        ]);

        $student = Student::findOrFail($request->student_id);
        $file = $request->file('document');

        $path = $file->store('students/documents', 'public');

        StudentDocument::create([
            'student_id' => $student->id,
            'titre' => $request->titre,
            'type' => $request->type,
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
        ]);

        return back()->with('success', 'Document ajouté.');
    }

    /**
     *  Téléchargement sécurisé
     */
    public function download(StudentDocument $document)
    {
        $path = storage_path('app/public/' . $document->file_path);
        if (!file_exists($path)) {
            return back()->with('error', 'Fichier introuvable sur le serveur.');
        }

        return response()->download($path, $document->titre . '.' . $document->file_type);
    }

    /**
     *  Suppression
     */
    public function destroy(StudentDocument $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document supprimé.');
    }
}
