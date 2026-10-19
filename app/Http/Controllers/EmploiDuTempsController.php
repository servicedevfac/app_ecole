<?php

namespace App\Http\Controllers;

use App\Models\Annee_scolaire;
use App\Models\Classe;
use App\Models\Emploi_du_temps;
use App\Models\Enseignant;
use App\Models\Horaire;
use App\Models\Jour;
use App\Models\Matiere;
use App\Models\Niveau;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class EmploiDuTempsController extends Controller
{
    public function downloadPDFByClasse($id)
    {
        $classe = Classe::findOrFail($id);
        $annee = Annee_scolaire::active();
        $jours = Jour::all();
        $horaires = Horaire::orderBy('heure_debut')->get();

        $schedules = Emploi_du_temps::with(['matiere', 'enseignant', 'horaire', 'jour'])
            ->where('classe_id', $id)
            ->get();

        $grid = [];
        foreach ($schedules as $s) {
            $grid[$s->horaire_id][$s->jours_id] = $s;
        }

        $data = [
            'schedules' => $schedules,
            'title' => 'Classe: ' . $classe->nom,
            'type' => 'classe',
            'annee' => $annee,
            'jours' => $jours,
            'horaires' => $horaires,
            'grid' => $grid
        ];

        $pdf = Pdf::loadView('admin.emploi_du_temps.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download('emploi_du_temps_' . $classe->nom . '.pdf');
    }

    /**
     *  Export PDF par enseignant
     */
    public function downloadPDFByTeacher($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $annee = Annee_scolaire::active();
        $jours = Jour::all();
        $horaires = Horaire::orderBy('heure_debut')->get();

        $schedules = Emploi_du_temps::with(['matiere', 'classe', 'horaire', 'jour'])
            ->where('enseignant_id', $id)
            ->get();

        $grid = [];
        foreach ($schedules as $s) {
            $grid[$s->horaire_id][$s->jours_id] = $s;
        }

        $data = [
            'schedules' => $schedules,
            'title' => 'Enseignant: ' . $enseignant->nom . ' ' . $enseignant->prenom,
            'type' => 'enseignant',
            'annee' => $annee,
            'jours' => $jours,
            'horaires' => $horaires,
            'grid' => $grid
        ];

        $pdf = Pdf::loadView('admin.emploi_du_temps.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download('emploi_du_temps_' . $enseignant->nom . '.pdf');
    }


    public function index(Request $request)
    {
        $niveaux = Niveau::all();
        $query = Classe::with('niveau')->withCount('emploisDuTemps');

        if ($request->search) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        if ($request->niveau_id) {
            $query->where('niveau_id', $request->niveau_id);
        }

        $classes = $query->orderBy('nom')->get();

        return view('admin.emploi_du_temps.index', compact('classes', 'niveaux'));
    }

    /**
     *  Formulaire création
     */
    public function create(Request $request)
    {
        $classeId = $request->get('classe_id');

        return view('admin.emploi_du_temps.create', [
            'classes' => Classe::all(),
            'matieres' => Matiere::all(),
            'enseignants' => Enseignant::all(),
            'annees' => Annee_scolaire::where('status', 'actif')->get(),
            'horaires' => Horaire::all(),
            'jours' => Jour::all(),
            'selectedClasseId' => $classeId,
        ]);
    }

    /**
     * 💾 Enregistrement
     */
    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'horaire_id' => 'required|exists:horaires,id',
            'jours_id' => 'required|exists:jours,id',
            'salle' => 'nullable|string|max:100',
        ]);

        // Récupérer l'horaire pour dériver heure_debut / heure_fin
        $horaire = Horaire::findOrFail($request->horaire_id);
        $heureDebut = $horaire->heure_debut;
        $heureFin = $horaire->heure_fin;

        // 🔥 CONTRÔLE DES CONFLITS
        $conflict = Emploi_du_temps::where('jours_id', $request->jours_id)
            ->where('annee_scolaire_id', $request->annee_scolaire_id)
            ->where(function ($q) use ($request) {
                $q->where('classe_id', $request->classe_id)
                    ->orWhere('enseignant_id', $request->enseignant_id);
            })
            ->whereHas('horaire', function ($q) use ($heureDebut, $heureFin) {
                $q->where('heure_debut', '<', $heureFin)
                    ->where('heure_fin', '>', $heureDebut);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(
                'Conflit horaire : classe ou enseignant indisponible.'
            )->withInput();
        }

        $horaire = Horaire::findOrFail($request->horaire_id);

        $heureDebut = $horaire->heure_debut;
        $heureFin = $horaire->heure_fin;
        if ($heureDebut >= $heureFin) {
            return back()->withErrors([
                'horaire' => 'L’heure de début doit être inférieure à l’heure de fin.'
            ]);
        }




        Emploi_du_temps::create([
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
            'enseignant_id' => $request->enseignant_id,
            'annee_scolaire_id' => $request->annee_scolaire_id,
            'horaire_id' => $request->horaire_id,
            'jours_id' => $request->jours_id,
            'salle' => $request->salle,
        ]);

        return redirect()
            ->route('admin.emploi_du_temps.index')
            ->with('success', 'Cours planifié avec succès.');
    }

    /**
     * ✏️ Édition
     */
    public function edit(Emploi_du_temps $emploi_du_temps)
    {
        return view('admin.emploi_du_temps.edit', [
            'emploi_du_temps' => $emploi_du_temps->load(['classe', 'matiere', 'enseignant', 'anneeScolaire', 'horaire', 'jour']),
            'classes' => Classe::all(),
            'matieres' => Matiere::all(),
            'enseignants' => Enseignant::all(),
            'annees' => Annee_scolaire::where('status', 'actif')->get(),
            'horaires' => Horaire::all(),
            'jours' => Jour::all(),
        ]);
    }

    /**
     * 🔄 Mise à jour
     */
    public function update(Request $request, Emploi_du_temps $emploi_du_temps)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'horaire_id' => 'required|exists:horaires,id',
            'jours_id' => 'required|exists:jours,id',
            'salle' => 'nullable|string|max:100',
        ]);

        $horaire = Horaire::findOrFail($request->horaire_id);
        $heureDebut = $horaire->heure_debut;
        $heureFin = $horaire->heure_fin;

        $conflict = Emploi_du_temps::where('id', '!=', $emploi_du_temps->id)
            ->where('jours_id', $request->jours_id)
            ->where('annee_scolaire_id', $request->annee_scolaire_id)
            ->where(function ($q) use ($request) {
                $q->where('classe_id', $request->classe_id)
                    ->orWhere('enseignant_id', $request->enseignant_id);
            })
            ->whereHas('horaire', function ($q) use ($heureDebut, $heureFin) {
                $q->where('heure_debut', '<', $heureFin)
                    ->where('heure_fin', '>', $heureDebut);
            })->exists();

        if ($conflict) {
            return back()->withErrors('Conflit horaire détecté.');
        }

        $emploi_du_temps->update([
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
            'enseignant_id' => $request->enseignant_id,
            'annee_scolaire_id' => $request->annee_scolaire_id,
            'horaire_id' => $request->horaire_id,
            'jours_id' => $request->jours_id,
            'salle' => $request->salle,
        ]);

        return redirect()
            ->route('admin.emploi_du_temps.index')
            ->with('success', 'Emploi du temps mis à jour.');
    }

    public function show(Emploi_du_temps $emploi_du_temps)
    {
        $emploi_du_temps->load(['classe', 'matiere', 'enseignant', 'anneeScolaire', 'horaire', 'jour']);
        return view('admin.emploi_du_temps.show', compact('emploi_du_temps'));
    }

    /**
     *  Suppression
     */
    public function destroy(Emploi_du_temps $emploi_du_temps)
    {
        $emploi_du_temps->delete();
        return redirect()
            ->route('admin.emploi_du_temps.index')
            ->with('success', 'Cours supprimé.');
    }
    /**
     *  Vue par CLASSE
     */
    public function byClasse($id)
    {
        $classe = Classe::findOrFail($id);
        $jours = Jour::all();
        $horaires = Horaire::orderBy('heure_debut')->get();
        
        $schedules = Emploi_du_temps::with(['matiere', 'enseignant', 'horaire', 'jour'])
            ->where('classe_id', $id)
            ->get();

        // Organiser les données pour la grille [horaire_id][jour_id]
        $grid = [];
        foreach ($schedules as $s) {
            $grid[$s->horaire_id][$s->jours_id] = $s;
        }

        return view('admin.emploi_du_temps.by-classe', compact('schedules', 'classe', 'jours', 'horaires', 'grid'));
    }

    /**
     *  Vue par ENSEIGNANT
     */
    public function byTeacher($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $jours = Jour::all();
        $horaires = Horaire::orderBy('heure_debut')->get();

        $schedules = Emploi_du_temps::with(['classe', 'matiere', 'horaire', 'jour'])
            ->where('enseignant_id', $id)
            ->get();

        $grid = [];
        foreach ($schedules as $s) {
            $grid[$s->horaire_id][$s->jours_id] = $s;
        }

        return view('admin.emploi_du_temps.by-teacher', compact('schedules', 'enseignant', 'jours', 'horaires', 'grid'));
    }

    /**
     * 🏫 Vue par SALLE
     */
    public function bySalle($salle)
    {
        $schedules = Emploi_du_temps::with(['classe', 'matiere', 'enseignant', 'horaire', 'jour'])
            ->where('salle', $salle)
            ->orderBy('jours_id')
            ->orderBy('horaire_id')
            ->get();

        return view('admin.emploi_du_temps.by-salle', compact('schedules', 'salle'));
    }

    /**
     * 👨‍🏫 Récupérer les enseignants assignés à une classe et une matière
     */
    public function getTeachersByClasseAndMatiere(Request $request)
    {
        $user = auth()->user();
        $matiere_id = $request->matiere_id;
        $classe_id = $request->classe_id;

        $query = \App\Models\AffectationsPedagogiques::with('enseignant')
            ->where('matiere_id', $matiere_id);

        if ($classe_id) {
            $query->where('classe_id', $classe_id);
        }

        // Si l'utilisateur est un enseignant, il ne peut voir que lui-même
        if ($user && $user->enseignant) {
            $query->where('enseignant_id', $user->enseignant->id);
        }

        $teachers = $query->get()
            ->map(function($affectation) {
                return [
                    'id' => $affectation->enseignant->id,
                    'name' => $affectation->enseignant->nom . ' ' . $affectation->enseignant->prenom,
                ];
            })
            ->unique('id')
            ->values();

        return response()->json($teachers);
    }
}
