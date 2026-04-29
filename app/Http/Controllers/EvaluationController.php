<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Enseignant;
use App\Models\Evaluation;
use App\Models\Matiere;
use App\Models\Student;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Http\Requests\EvaluationRequest;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodes = Periode::get();
        $classes = Classe::get();
        $matieres = Matiere::get();
        $enseignants = Enseignant::get();
        $evaluations = Evaluation::with('periode')->paginate(10);
        return view('admin.evaluations.index', compact('evaluations', 'classes', 'matieres', 'enseignants', 'periodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $enseignants = Enseignant::all();
        $periodes = Periode::where('status', 'ouvert')->get();
        return view('admin.evaluations.create', compact('classes', 'matieres', 'enseignants', 'periodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EvaluationRequest $request)
    {
        $periode = Periode::findOrFail($request->periode_id);
        if ($periode->anneeScolaire->status === 'archived') {
            return back()->with('error', 'Impossible de créer une évaluation dans une année archivée.');
        }

        Evaluation::create($request->all());

        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        // Récupérer les étudiants via les inscriptions valides pour la classe de l'évaluation
        $students = Student::whereHas('inscriptions', function ($query) use ($evaluation) {
            $query->where('classe_id', $evaluation->classe_id)
                ->where('status', 'inscrite');
        })
            ->with([
                'notes' => function ($query) use ($evaluation) {
                    $query->where('evaluation_id', $evaluation->id);
                }
            ])
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('admin.evaluations.show', compact('evaluation', 'students'));
    }


    public function edit(Evaluation $evaluation)
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $enseignants = Enseignant::all();
        $periodes = Periode::where('status', 'ouvert')->get();
        return view('admin.evaluations.edit', compact('evaluation', 'classes', 'matieres', 'enseignants', 'periodes'));
    }


    public function update(Request $request, Evaluation $evaluation)
    {
        if ($evaluation->estArchivee()) {
            return back()->with('error', 'Modification impossible : cette année est archivée.');
        }

        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'periode_id' => 'required|exists:periodes,id',
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
        if ($evaluation->estArchivee()) {
            return back()->with('error', 'Suppression impossible : cette année est archivée.');
        }

        $evaluation->delete();

        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation supprimée avec succès');
    }
}
