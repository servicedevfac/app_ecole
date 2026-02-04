<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Enseignant;
use App\Models\Evaluation;
use App\Models\Matiere;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $enseignants = Enseignant::all();
        $evaluations = Evaluation::all();
        return view('admin.evaluations.index', compact('evaluations', 'classes', 'matieres', 'enseignants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $enseignants = Enseignant::all();
        return view('admin.evaluations.create', compact('classes', 'matieres', 'enseignants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'type' => 'required|in:Devoir,Interrogation,Examen',
            'date_evaluation' => 'required|date',
            'coefficient' => 'required|numeric|min:0.1',
            'note_max' => 'required|integer|min:1',
            'statut' => 'required|in:brouillon,validee',
        ]);

        Evaluation::create($request->all());

        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        return view('admin.evaluations.show', compact('evaluation'));
    }

   
    public function edit(Evaluation $evaluation)
    {
        return view('admin.evaluations.edit', compact('evaluation'));
    }


    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:users,id',
            'libelle' => 'required|string|max:255',
            'type' => 'required|in:Devoir,Interrogation,Examen',
            'date_evaluation' => 'required|date',
            'coefficient' => 'required|numeric|min:0.1',
            'note_max' => 'required|integer|min:1',
            'statut' => 'required|in:brouillon,validee',
        ]);

        $evaluation->update($request->all());

        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation mise à jour avec succès');
    }


    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();

        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation supprimée avec succès');
    }
}
