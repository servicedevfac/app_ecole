<?php

namespace App\Http\Controllers;

use App\Models\AffectationsPedagogiques;
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
    public function index(Request $request)
    {
        $user = auth()->user();
        $periodes = Periode::get();

        $query = Evaluation::query();

        // Si l'utilisateur est un enseignant, on filtre par son ID
        if ($user->enseignant) {
            $enseignantId = $user->enseignant->id;
            $query->where('enseignant_id', $enseignantId);

            // Filtres pour l'enseignant
            $affectations = AffectationsPedagogiques::where('enseignant_id', $enseignantId)->get();
            $classes = Classe::whereIn('id', $affectations->pluck('classe_id'))->get();
            $matieres = Matiere::whereIn('id', $affectations->pluck('matiere_id'))->get();
            $enseignants = Enseignant::where('id', $enseignantId)->get();
        } else {
            $classes = Classe::get();
            $matieres = Matiere::get();
            $enseignants = Enseignant::get();
        }

        // Filtre par classe
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        // Filtre par matière
        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        // Filtre par enseignant (seulement si admin car pour enseignant c'est déjà filtré)
        if ($request->filled('enseignant_id') && !$user->enseignant) {
            $query->where('enseignant_id', $request->enseignant_id);
        }

        // Filtre par période
        if ($request->filled('periode_id')) {
            $query->where('periode_id', $request->periode_id);
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $evaluations = $query->with(['periode', 'classe', 'matiere', 'enseignant'])->paginate(30);
        return view('admin.evaluations.index', compact('evaluations', 'classes', 'matieres', 'enseignants', 'periodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $periodes = Periode::where('status', 'ouvert')->get();

        if ($user->enseignant) {
            $enseignantId = $user->enseignant->id;
            $affectations = AffectationsPedagogiques::where('enseignant_id', $enseignantId)->get();

            $classes = Classe::whereIn('id', $affectations->pluck('classe_id'))->get();
            $matieres = Matiere::whereIn('id', $affectations->pluck('matiere_id'))->get();
            $enseignants = Enseignant::where('id', $enseignantId)->get();
        } else {
            $classes = Classe::all();
            $matieres = Matiere::all();
            $enseignants = Enseignant::all();
        }

        return view('admin.evaluations.create', compact('classes', 'matieres', 'periodes', 'enseignants'));
    }

    /**
     * Store a newly created resource in storage.
     */public function store(EvaluationRequest $request)
        {
            $periode = Periode::findOrFail($request->periode_id);

            if ($periode->anneeScolaire->status === 'archived') {
                return back()->with(
                    'error',
                    'Impossible de créer une évaluation dans une année archivée.'
                );
            }

            $data = $request->validated();

            $user = auth()->user();

            if ($user->enseignant) {
                $data['enseignant_id'] = $user->enseignant->id;
            }

            $data['ecole_id'] = $user->ecole_id;

            Evaluation::create($data);

            return redirect()
                ->route('admin.evaluations.index')
                ->with('success', 'Évaluation créée avec succès');
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
        $user = auth()->user();
        $periodes = Periode::where('status', 'ouvert')->get();

        if ($user->enseignant) {
            $enseignantId = $user->enseignant->id;

            // Vérifier si l'évaluation appartient à l'enseignant
            if ($evaluation->enseignant_id !== $enseignantId) {
                abort(403, 'Accès non autorisé.');
            }

            $affectations = AffectationsPedagogiques::where('enseignant_id', $enseignantId)->get();
            $classes = Classe::whereIn('id', $affectations->pluck('classe_id'))->get();
            $matieres = Matiere::whereIn('id', $affectations->pluck('matiere_id'))->get();
            $enseignants = Enseignant::where('id', $enseignantId)->get();
        } else {
            $classes = Classe::all();
            $matieres = Matiere::all();
            $enseignants = Enseignant::all();
        }

        return view('admin.evaluations.edit', compact('evaluation', 'classes', 'matieres', 'enseignants', 'periodes'));
    }


    public function update(Request $request, Evaluation $evaluation)
    {
        $user = auth()->user();
        if ($user->enseignant && $evaluation->enseignant_id !== $user->enseignant->id) {
            abort(403, 'Accès non autorisé.');
        }

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
        $user = auth()->user();
        if ($user->enseignant && $evaluation->enseignant_id !== $user->enseignant->id) {
            abort(403, 'Accès non autorisé.');
        }

        if ($evaluation->estArchivee()) {
            return back()->with('error', 'Suppression impossible : cette année est archivée.');
        }

        $evaluation->delete();

        return redirect()->route('admin.evaluations.index')->with('success', 'Évaluation supprimée avec succès');
    }
}
