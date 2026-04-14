<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = \App\Models\Classe::all();
        $periodes = \App\Models\Periode::all();
        $enseignants = \App\Models\Enseignant::all();

        foreach ($classes as $classe) {
            $inscriptions = $classe->inscriptions;
            if ($inscriptions->isEmpty()) continue;

            $affectations = \App\Models\AffectationsPedagogiques::where('classe_id', $classe->id)->get();
            
            foreach ($periodes as $periode) {
                foreach ($affectations as $affectation) {
                    // Créer une évaluation pour chaque matière affectée dans chaque période
                    $evaluation = \App\Models\Evaluation::create([
                        'classe_id' => $classe->id,
                        'matiere_id' => $affectation->matiere_id,
                        'enseignant_id' => $affectation->enseignant->user_id,
                        'libelle' => 'Évaluation ' . $affectation->matiere->nom,
                        'type' => rand(0, 1) ? 'Devoir' : 'Examen',
                        'date_evaluation' => $periode->date_debut,
                        'coefficient' => rand(1, 3),
                        'note_max' => 20,
                        'statut' => 'validee',
                        'periode_id' => $periode->id,
                    ]);

                    // Créer des notes pour chaque élève inscrit dans la classe
                    foreach ($inscriptions as $inscription) {
                        \App\Models\Note::create([
                            'evaluation_id' => $evaluation->id,
                            'student_id' => $inscription->student_id,
                            'note' => rand(8, 18) + (rand(0, 99) / 100),
                            'appreciation' => 'Bon travail',
                        ]);
                    }
                }
            }
        }
    }
}
