<?php

namespace App\Http\Controllers;

use App\Models\Annee_scolaire;
use App\Models\Classe;
use App\Models\Emploi_du_temps;
use App\Models\Enseignant;
use App\Models\Horaire;
use App\Models\Jour;
use App\Models\Matiere;
use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
   

    public function index(Request $request)
    {
        $query = Emploi_du_temps::with(['classe', 'matiere', 'enseignant', 'anneeScolaire', 'horaire', 'jour']);

        if ($request->classe_id) {
            $query->where('classe_id', $request->classe_id);
        }

        if ($request->enseignant_id) {
            $query->where('enseignant_id', $request->enseignant_id);
        }

        $emploi_du_temps = $query
            ->orderBy('jours_id')
            ->orderBy('horaire_id')
            ->get();

        return view('admin.emploi_du_temps.index', compact('emploi_du_temps'));
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
            $heureFin   = $horaire->heure_fin;
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
            })
            ->exists();

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
        $schedules = Emploi_du_temps::with(['matiere','enseignant', 'horaire', 'jour'])
            ->where('classe_id', $id)
            ->orderBy('jours_id')
            ->orderBy('horaire_id')
            ->get();

        return view('admin.emploi_du_temps.by-classe', compact('schedules'));
    }

    /**
     *  Vue par ENSEIGNANT
     */
    public function byTeacher($id)
    {
        $schedules = Emploi_du_temps::with(['classe','matiere','enseignant', 'horaire', 'jour'])
            ->where('enseignant_id', $id)
            ->orderBy('jours_id')
            ->orderBy('horaire_id')
            ->get();

        return view('admin.emploi_du_temps.by-teacher', compact('schedules'));
    }

    /**
     * 🏫 Vue par SALLE
     */
    public function bySalle($salle)
    {
        // Note: La colonne salle n'existe pas dans la migration actuelle
        // Cette méthode est désactivée jusqu'à ce que la colonne soit ajoutée
        $schedules = collect([]);
        return view('admin.emploi_du_temps.by-salle', compact('schedules', 'salle'));
    }

}
