<?php

namespace App\Http\Controllers;

use App\Models\Annee_scolaire;
use App\Models\Classe;
use App\Models\Cycle;
use App\Models\Inscription;
use App\Models\Niveau;
use App\Models\Student;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inscriptions = Inscription::all();
        return view('admin.etudiant.inscription.index', compact('inscriptions'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $annees = Annee_scolaire::all();
        $etudiants = Student::all();
        $cycles = Cycle::all();
        $niveaux = Niveau::all();
        $classes = Classe::all();

        return view('admin.etudiant.affectation', compact(
            'annees', 'etudiants', 'cycles', 'niveaux', 'classes'
        ));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $anneeActive = Annee_scolaire::active();

        if (!$anneeActive) {
            abort(403, 'Aucune année scolaire active');
        }

         $validated = $request->validate([
        'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
        'student_id'        => 'required|exists:students,id',
        'cycle_id'          => 'required|exists:cycles,id',
        'niveau_id'         => 'required|exists:niveaux,id',
        'classe_id'         => 'required|exists:classes,id',
    ]);

    // Vérifier cohérence Cycle → Niveau → Classe
    $niveau = Niveau::findOrFail($request->niveau_id);
    $classe = Classe::findOrFail($request->classe_id);

    if ($niveau->cycle_id != $request->cycle_id) {
        return back()->withErrors(['cycle_id' => 'Le niveau choisi n’appartient pas au cycle sélectionné.'])->withInput();
    }

    if ($classe->niveau_id != $niveau->id) {
        return back()->withErrors(['classe_id' => 'La classe choisie n’appartient pas au niveau sélectionné.'])->withInput();
    }

    // Créer ou mettre à jour l'inscription
    Inscription::updateOrCreate(
        [
            'student_id'        => $request->student_id,
            'annee_scolaire_id' => $request->annee_scolaire_id
        ],
        [
            'cycle_id'  => $request->cycle_id,
            'niveau_id' => $request->niveau_id,
            'classe_id' => $request->classe_id
        ]
    );


        
        return redirect()->route('admin.inscription.index')->with('success', 'Inscription effectue avec succes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inscription = Inscription::findOrFail($id);
        return view('admin.etudiant.inscription.show', compact('inscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inscription = Inscription::findOrFail($id);
        return view('admin.etudiant.inscription.edit', compact('inscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anneeActive = Annee_scolaire::active();

        if (!$anneeActive) {
            abort(403, 'Aucune année scolaire active');
        }

        $request->validate([
            'student_id' => 'required',
            'annee_scolaire_id' => 'required',
            'cycle_id' => 'required',
            'niveau_id' => 'required',
            'classe_id' => 'required',

        ]);

        $inscription = Inscription::findOrFail($id);
        $inscription->update([
            'student_id' => $request->student_id,
            'classe_id' => $request->classe_id,
            'niveau_id' => $request->niveau_id,
            'cycle_id' => $request->cycle_id,
            'annee_scolaire_id' => $anneeActive->id,
        ]);
        return redirect()->route('admin.inscription.index')->with('success', 'Inscription modifie avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inscription = Inscription::findOrFail($id);
        $inscription->delete();
        return redirect()->route('admin.inscription.index')->with('success', 'Inscription supprime avec succes'); 
    }
}
