<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Student;
use App\Models\Annee_scolaire;
use App\Models\Matiere;
use App\Models\Evaluation;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Services\BulletinService;
use Barryvdh\DomPDF\Facade\Pdf;

class BulletinController extends Controller
{
    protected $bulletinService;

    public function __construct(BulletinService $bulletinService)
    {
        $this->bulletinService = $bulletinService;
    }
    public function index(Request $request)
    {
        $classes = Classe::all();
        $selected_annee_id = $request->query('annee_scolaire_id');
        $annee = null;
        
        if ($selected_annee_id) {
            $annee = Annee_scolaire::findOrFail($selected_annee_id);
        }

        $annees = Annee_scolaire::orderBy('date_debut', 'desc')->get();

        if (!$annee && $annees->count() > 0) {
            $annee = $annees->first();
        }

        if (!$annee) {
            return back()->with('error', 'Aucune année scolaire trouvée. Veuillez en créer une première.');
        }

        $periodes = $annee ? $annee->periodes : collect();
        $selected_periode_id = $request->query('periode_id');
        
        return view('admin.bulletins.index', compact('classes', 'periodes', 'selected_periode_id', 'annees', 'annee'));
    }

    public function generate(Request $request, Classe $classe)
    {
        $selected_annee_id = $request->query('annee_scolaire_id');
        
        if ($selected_annee_id) {
            $annee = Annee_scolaire::findOrFail($selected_annee_id);
        } else {
            $annee = Annee_scolaire::active();
        }

        if (!$annee) {
            return back()->with('error', 'Aucune année scolaire active.');
        }

        $periode_id = $request->query('periode_id');
        $periode = $periode_id ? Periode::find($periode_id) : null;

        $data = $this->bulletinService->getBulletinsData($classe, $periode, $annee);
        $bulletins = $data['bulletins'];
        $matieres = $data['matieres'];
        $classStats = $data['classStats'];

        return view('admin.bulletins.show', compact('classe', 'bulletins', 'matieres', 'annee', 'periode', 'classStats'));
    }

    public function studentBulletin(Request $request, Classe $classe, Student $student)
    {
        $annee = Annee_scolaire::active();
        if (!$annee) {
            return back()->with('error', 'Aucune année scolaire active.');
        }

        $periode_id = $request->query('periode_id');
        $periode = $periode_id ? Periode::find($periode_id) : null;

        $data = $this->bulletinService->getBulletinsData($classe, $periode, $annee);
        $bulletins = $data['bulletins'];
        $matieres = $data['matieres'];
        $classStats = $data['classStats'];

        // Trouver le bulletin spécifique de l'élève
        $bulletin = collect($bulletins)->where('student.id', $student->id)->first();

        if (!$bulletin) {
            return back()->with('error', 'Aucune donnée disponible pour cet élève.');
        }

        $ecole = $student->ecole;

        return view('admin.bulletins.student', compact('classe', 'bulletin', 'matieres', 'annee', 'periode', 'classStats', 'ecole'));
    }

    public function downloadPDF(Request $request, Classe $classe, Student $student)
    {
        $annee = Annee_scolaire::active();
        if (!$annee) {
            return back()->with('error', 'Aucune année scolaire active.');
        }

        $periode_id = $request->query('periode_id');
        $periode = $periode_id ? Periode::find($periode_id) : null;

        $data = $this->bulletinService->getBulletinsData($classe, $periode, $annee);
        $bulletins = $data['bulletins'];
        $matieres = $data['matieres'];
        $classStats = $data['classStats'];

        // Trouver le bulletin spécifique de l'élève
        $bulletin = collect($bulletins)->where('student.id', $student->id)->first();

        if (!$bulletin) {
            return back()->with('error', 'Aucune donnée disponible pour cet élève.');
        }

        $ecole = $student->ecole;

        $pdf = Pdf::loadView('admin.bulletins.pdf', compact('classe', 'bulletin', 'matieres', 'annee', 'periode', 'classStats', 'ecole'))
            ->setPaper('a4', 'portrait');

        $fileName = 'Bulletin_' . strtoupper($student->nom) . '_' . strtoupper($student->prenom);
        if ($periode) {
            $fileName .= '_' . strtoupper(str_replace(' ', '_', $periode->nom));
        }
        $fileName .= '.pdf';

        return $pdf->download($fileName);
    }

    // Méthode getBulletinsData supprimée car déplacée dans BulletinService
}
