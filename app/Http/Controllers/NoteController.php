<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Evaluation;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
   

    public function create(Evaluation $evaluation)
    {
        if ($evaluation->statut === 'validée') {
            abort(403, 'Notes déjà validées');
        }

        // Récupérer les étudiants via les inscriptions valides pour la classe de l'évaluation
        $students = Student::whereHas('inscriptions', function($query) use ($evaluation) {
            $query->where('classe_id', $evaluation->classe_id)
                  ->where('status', 'inscrite'); // ou autre statut valide
        })
        ->with(['notes' => function($query) use ($evaluation) {
            $query->where('evaluation_id', $evaluation->id);
        }])
        ->orderBy('nom')
        ->orderBy('prenom')
        ->get();

        return view('admin.evaluations.saisie_note', compact('evaluation', 'students'));
    }

    public function store(Request $request, Evaluation $evaluation)
    {
        if ($evaluation->statut === 'validée') {
            return back()->with('error', 'Impossible de modifier des notes validées.');
        }

        $request->validate([
            'notes' => 'required|array',
            'notes.*' => 'nullable|numeric|min:0|max:' . $evaluation->note_max,
            'appreciations' => 'nullable|array',
            'appreciations.*' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $evaluation) {
            foreach ($request->notes as $student_id => $noteVal) {
                // Si la note est vide (null), on peut décider de supprimer la note existante ou de ne rien faire.
                // Ici, on part du principe qu'on met à jour ou crée si une valeur est fournie (y compris 0).
                // Si on veut permettre d'effacer une note, il faudrait gérer le cas null.
                
                if ($noteVal !== null) {
                    Note::updateOrCreate(
                        [
                            'evaluation_id' => $evaluation->id,
                            'student_id' => $student_id
                        ],
                        [
                            'note' => $noteVal,
                            'appreciation' => $request->appreciations[$student_id] ?? null
                        ]
                    );
                }
            }
        });

        return back()->with('success', 'Notes enregistrées avec succès.');
    }

    public function valider(Evaluation $evaluation)
    {
        if ($evaluation->statut === 'validée') {
            abort(403, 'Notes déjà validées');
        }

        $evaluation->update(['statut' => 'validée']);

        return redirect()->route('admin.evaluations.index')
            ->with('success', 'Notes validées avec succès');
    }
    


}
