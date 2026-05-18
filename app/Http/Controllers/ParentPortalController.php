<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Student;
use App\Models\Note;
use App\Models\Presence;
use App\Models\Facture;
use App\Models\Annee_scolaire;
use App\Models\StudentDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParentPortalController extends Controller
{
    public function index()
    {
        $parent = $this->getParent();
        $students = collect();
        $selectedStudent = null;
        $recentNotes = collect();
        $recentPresences = collect();
        $unpaidFactures = collect();
        $anneeActive = Annee_scolaire::active();

        if ($parent) {
            $students = $parent->students()->with(['classe'])->get();

            if (session()->has('selected_student_id')) {
                $selectedStudent = Student::with(['classe'])->find(session('selected_student_id'));
            }

            // If no student is selected and parent has children, select the first one by default
            if (!$selectedStudent && $students->count() > 0) {
                $selectedStudent = $students->first();
                session(['selected_student_id' => $selectedStudent->id]);
            }

            if ($selectedStudent) {
                $recentNotes = Note::where('student_id', $selectedStudent->id)
                    ->with('evaluation.matiere')
                    ->latest()
                    ->take(5)
                    ->get();

                $recentPresences = Presence::where('student_id', $selectedStudent->id)
                    ->latest()
                    ->take(5)
                    ->get();

                $unpaidFactures = Facture::whereHas('inscription', function($q) use ($selectedStudent) {
                    $q->where('student_id', $selectedStudent->id);
                })->where('statut', '!=', 'soldé')->get();
            }
        }

        return view('parent.dashboard', compact('parent', 'students', 'selectedStudent', 'recentNotes', 'recentPresences', 'unpaidFactures', 'anneeActive'));
    }

    public function selectStudent($id)
    {
        $parent = $this->getParent();
        
        if ($parent->students->contains($id)) {
            session(['selected_student_id' => $id]);
            return back()->with('success', 'Enfant sélectionné avec succès.');
        }

        return back()->with('error', 'Accès non autorisé.');
    }

    public function notes()
    {
        $selectedStudent = $this->getSelectedStudent();
        $notes = Note::where('student_id', $selectedStudent->id)
            ->with(['evaluation.matiere', 'evaluation.anneeScolaire', 'evaluation.periode'])
            ->latest()
            ->get()
            ->groupBy(function($note) {
                return $note->evaluation->matiere->nom ?? 'Inconnu';
            });

        return view('parent.notes', compact('selectedStudent', 'notes'));
    }

    public function emploiDuTemps()
    {
        $selectedStudent = $this->getSelectedStudent();
        $classe = $selectedStudent->classe;
        
        if (!$classe) {
            return back()->with('error', 'Aucune classe affectée pour cet enfant.');
        }

        $jours = \App\Models\Jour::orderBy('id')->get();
        $horaires = \App\Models\Horaire::orderBy('heure_debut')->get();
        $schedules = \App\Models\Emploi_du_temps::where('classe_id', $classe->id)
            ->with(['matiere', 'enseignant', 'horaire', 'jour'])
            ->get();

        $grid = [];
        foreach ($schedules as $s) {
            $grid[$s->horaire_id][$s->jours_id] = $s;
        }

        return view('parent.emploi', compact('selectedStudent', 'classe', 'jours', 'horaires', 'grid'));
    }

    public function factures()
    {
        $selectedStudent = $this->getSelectedStudent();
        $factures = Facture::whereHas('inscription', function($q) use ($selectedStudent) {
            $q->where('student_id', $selectedStudent->id);
        })->with('payments')->latest()->get();

        return view('parent.factures', compact('selectedStudent', 'factures'));
    }

    public function documents()
    {
        $selectedStudent = $this->getSelectedStudent();
        $documents = $selectedStudent->documents;

        return view('parent.documents', compact('selectedStudent', 'documents'));
    }

    public function downloadDocument(StudentDocument $document)
    {
        $selectedStudent = $this->getSelectedStudent();
        if ($document->student_id != $selectedStudent->id) {
            abort(403);
        }

        return response()->download(storage_path('app/public/' . $document->file_path));
    }

    public function presences()
    {
        $selectedStudent = $this->getSelectedStudent();
        $presences = Presence::where('student_id', $selectedStudent->id)->latest()->get();

        return view('parent.presences', compact('selectedStudent', 'presences'));
    }

    public function profile()
    {
        $parent = $this->getParent();
        return view('parent.profile', compact('parent'));
    }

    public function showChangePasswordForm()
    {
        return view('parent.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false
        ]);

        return redirect()->route('parent.dashboard')->with('success', 'Mot de passe modifié avec succès.');
    }

    private function getParent()
    {
        $parent = Parents::where('user_id', Auth::id())->first();
        
        if (!$parent && Auth::user()->hasRole('Super Admin')) {
            // Pour le Super Admin, on prend le premier parent disponible pour le test
            $parent = Parents::first();
        }

        return $parent;
    }

    private function getSelectedStudent()
    {
        if (!session()->has('selected_student_id')) {
            $parent = $this->getParent();
            $student = $parent->students->first();
            if (!$student) abort(404, 'Aucun enfant trouvé.');
            session(['selected_student_id' => $student->id]);
            return $student;
        }

        $student = Student::find(session('selected_student_id'));
        if (!$student) abort(404, 'Élève non trouvé.');
        
        return $student;
    }
}
