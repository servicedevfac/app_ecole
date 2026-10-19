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
use ZipArchive;
use Illuminate\Support\Facades\File;

class BulletinController extends Controller
{
    protected $bulletinService;

    public function __construct(BulletinService $bulletinService)
    {
        $this->bulletinService = $bulletinService;
    }
    public function index(Request $request)
    {
        $selected_annee_id = $request->query('annee_scolaire_id');
        $annees = Annee_scolaire::orderBy('date_debut', 'desc')->get();
        
        $annee = null;
        if ($selected_annee_id) {
            $annee = Annee_scolaire::findOrFail($selected_annee_id);
        } elseif ($annees->count() > 0) {
            $annee = $annees->first();
        }

        if (!$annee) {
            return back()->with('error', 'Aucune année scolaire trouvée.');
        }

        $query = Classe::with('niveau');
        if ($request->search) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }
        if ($request->niveau_id) {
            $query->where('niveau_id', $request->niveau_id);
        }
        $classes = $query->get();
        
        $niveaux = \App\Models\Niveau::all();
        $periodes = $annee->periodes;
        $selected_periode_id = $request->query('periode_id');
        
        return view('admin.bulletins.index', compact('classes', 'periodes', 'selected_periode_id', 'annees', 'annee', 'niveaux'));
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
//
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

    public function downloadAllPDFs(Request $request, Classe $classe)
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

        if (empty($bulletins)) {
            return back()->with('error', 'Aucun bulletin à télécharger.');
        }

        $zip = new ZipArchive;
        $zipFileName = 'Bulletins_' . str_replace(' ', '_', $classe->nom);
        if ($periode) {
            $zipFileName .= '_' . str_replace(' ', '_', $periode->nom);
        }
        $zipFileName .= '.zip';
        
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($bulletins as $bulletin) {
                $student = $bulletin['student'];
                $ecole = $student->ecole;

                $pdf = Pdf::loadView('admin.bulletins.pdf', compact('classe', 'bulletin', 'matieres', 'annee', 'periode', 'classStats', 'ecole'))
                    ->setPaper('a4', 'portrait');

                $fileName = 'Bulletin_' . strtoupper($student->nom) . '_' . strtoupper($student->prenom) . '.pdf';
                
                $zip->addFromString($fileName, $pdf->output());
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
