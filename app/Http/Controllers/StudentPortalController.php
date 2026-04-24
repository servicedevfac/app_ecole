<?php

namespace App\Http\Controllers;

use App\Models\Annee_scolaire;
use App\Models\Student;
use App\Models\Evaluation;
use App\Models\Inscription;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentPortalController extends Controller
{
    private function getStudent()
    {
        return Student::where('user_id', Auth::id())->firstOrFail();
    }

    public function index()
    {
        $student = $this->getStudent();
        $anneeActive = Annee_scolaire::active();

        // Récupérer l'inscription active
        $inscription = $student->inscriptions()
            ->where('annee_scolaire_id', $anneeActive?->id)
            ->first();

        // Statistiques de base
        $notesCount = $student->notes()->count();
        $absencesCount = $student->presences()->where('statut', 'absent')->count();
        
        $facture = $inscription?->factures()->first();
        $resteAPayer = $facture?->reste ?? 0;

        // Évaluations récentes
        $recentNotes = $student->notes()->with(['evaluation.matiere', 'evaluation.periode'])
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'student',
            'inscription',
            'notesCount',
            'absencesCount',
            'resteAPayer',
            'recentNotes',
            'anneeActive'
        ));
    }

    public function notes()
    {
        $student = $this->getStudent();
        $anneeActive = Annee_scolaire::active();
        
        $inscriptions = $student->inscriptions()
            ->with(['anneeScolaire', 'classe.niveau'])
            ->orderBy('annee_scolaire_id', 'desc')
            ->get();

        $selectedInscriptionId = request('inscription_id', $inscriptions->first()?->id);
        $selectedInscription = $inscriptions->where('id', $selectedInscriptionId)->first();

        $notes = $student->notes()
            ->whereHas('evaluation', function($q) use ($selectedInscription) {
                if ($selectedInscription) {
                   // Filtrer par période si nécessaire, ou juste par inscription
                }
            })
            ->with(['evaluation.matiere', 'evaluation.periode'])
            ->get()
            ->groupBy(fn($note) => $note->evaluation->periode->nom ?? 'Général');

        return view('student.notes', compact('student', 'inscriptions', 'notes', 'selectedInscriptionId'));
    }

    public function emploiDuTemps()
    {
        $student = $this->getStudent();
        $anneeActive = Annee_scolaire::active();
        
        $inscription = $student->inscriptions()
            ->where('annee_scolaire_id', $anneeActive?->id)
            ->first();

        if (!$inscription || !$inscription->classe) {
            return view('student.emploi', ['student' => $student, 'horaires' => [], 'jours' => []]);
        }

        $classe = $inscription->classe;
        $emplois = $classe->emploisDuTemps()
            ->with(['matiere', 'horaire', 'jour', 'enseignant'])
            ->get();

        $jours = \App\Models\Jour::orderBy('id')->get();
        $horaires = \App\Models\Horaire::orderBy('heure_debut')->get();

        return view('student.emploi', compact('student', 'emplois', 'jours', 'horaires', 'classe'));
    }

    public function factures()
    {
        $student = $this->getStudent();
        
        $inscriptions = $student->inscriptions()
            ->with(['anneeScolaire', 'factures.payments'])
            ->orderBy('annee_scolaire_id', 'desc')
            ->get();

        return view('student.factures', compact('student', 'inscriptions'));
    }

    public function documents()
    {
        $student = $this->getStudent();
        $documents = $student->documents()->latest()->get();

        return view('student.documents', compact('student', 'documents'));
    }

    public function downloadDocument(\App\Models\StudentDocument $document)
    {
        $student = $this->getStudent();
        
        // Sécurité : Vérifier que le document appartient bien à l'élève connecté
        if ($document->student_id !== $student->id) {
            abort(403, 'Action non autorisée.');
        }

        $path = storage_path('app/public/' . $document->file_path);
        if (!file_exists($path)) {
            return back()->with('error', 'Fichier introuvable.');
        }

        return response()->download($path, $document->titre . '.' . $document->file_type);
    }

    public function showChangePasswordForm()
    {
        $student = $this->getStudent();
        return view('student.change-password', compact('student'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', 'Votre mot de passe a été mis à jour avec succès.');
    }
}
