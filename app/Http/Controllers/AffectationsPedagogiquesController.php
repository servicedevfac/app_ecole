<?php

namespace App\Http\Controllers;

use App\Models\affectations_pedagogiques;
use App\Models\Annee_scolaire;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Classe;
use Illuminate\Http\Request;

class AffectationsPedagogiquesController extends Controller
{
    //public function __construct()
   // {
   //     $this->middleware(['auth', 'permission:gerer-affectations']);
   // }

    /**
     * Liste des affectations
     */
    public function index(Request $request)
    {
        $query = affectations_pedagogiques::with([
            'enseignant',
            'matiere',
            'classe',
            'annee_scolaire'
        ]);

        // 🔍 Filtres
        if ($request->enseignant_id) {
            $query->where('enseignant_id', $request->enseignant_id);
        }

        if ($request->classe_id) {
            $query->where('classe_id', $request->classe_id);
        }

        if ($request->matiere_id) {
            $query->where('matiere_id', $request->matiere_id);
        }
   
        $affectations = $query->latest()->paginate(20);

           return view('admin.enseignant.affectations.index', compact('affectations'));
    }
    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('admin.enseignant.affectations.create', [
            'enseignants' => Enseignant::orderBy('nom')->get(),
            'matieres' => Matiere::orderBy('nom')->get(),
            'classes' => Classe::orderBy('nom')->get(),
            'annees' => Annee_scolaire::where('status', 'actif')->get(),
        ]);
    }

    /**
     * Enregistrement
     */
    public function store(Request $request)
    {
        $request->validate([
            'enseignant_id' => 'required|exists:enseignants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
        ]);

        $classe = Classe::findOrFail($request->classe_id);
        $matiere = Matiere::findOrFail($request->matiere_id);

        // ✅ Vérification cycle
        if ($classe->cycle_id !== $matiere->cycle_id) {
            return back()->withErrors([
                'matiere_id' => 'Cette matière n’appartient pas au cycle de la classe.'
            ])->withInput();
        }

        affectations_pedagogiques::create($request->all());

        return redirect()
            ->route('admin.enseignant.index')
            ->with('success', 'Affectation pédagogique créée avec succès.');
    }

    /**
     * Formulaire d’édition
     */
    public function edit(affectations_pedagogiques $affectationPedagogique)
    {
        return view('admin.enseignant.affectations.edit', [
            'affectation' => $affectationPedagogique,
            'enseignants' => Enseignant::orderBy('nom')->get(),
            'matieres' => Matiere::orderBy('nom')->get(),
            'classes' => Classe::orderBy('nom')->get(),
            'annees' => Annee_scolaire::where('status', true)->get(),
        ]);
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, affectations_pedagogiques $affectationPedagogique)
    {
        $request->validate([
            'enseignant_id' => 'required|exists:enseignants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
        ]);

        $classe = Classe::findOrFail($request->classe_id);
        $matiere = Matiere::findOrFail($request->matiere_id);

        if ($classe->cycle_id !== $matiere->cycle_id) {
            return back()->withErrors([
                'matiere_id' => 'Incohérence cycle / matière.'
            ]);
        }

        try {
            try {
            $affectationPedagogique->update($request->all());
        } catch (\Exception $e) {
            return back()->withErrors(
                'Une affectation identique existe déjà.'
            );
        }
        } catch (\Exception $e) {
            return back()->withErrors(
                'Une affectation identique existe déjà.'
            );
        }

        return redirect()
            ->route('admin.enseignant.index')
            ->with('success', 'Affectation mise à jour.');
    }

    /**
     * Suppression sécurisée
     */
    public function destroy(affectations_pedagogiques $affectationPedagogique)
    {
        // 🔐 Sécurité métier (exemple)
        if (method_exists($affectationPedagogique, 'notes')
            && $affectationPedagogique->notes()->exists()) {
            return back()->withErrors(
                'Suppression impossible : des notes sont déjà enregistrées.'
            );
        }

        $affectationPedagogique->delete();

        return redirect()
            ->route('admin.enseignant.index')
            ->with('success', 'Affectation supprimée avec succès.');
    }
}
