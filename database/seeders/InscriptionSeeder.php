<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inscription;

class InscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = \App\Models\Student::all();
        $classes = \App\Models\Classe::all();
        $anneeScolaire = \App\Models\Annee_scolaire::where('status', 'actif')->first();
        

        if (!$anneeScolaire) {
            $this->command->warn("Aucune année scolaire active trouvée. Les inscriptions n'ont pas été créées.");
            return;
        }

        if ($students->isEmpty()) {
            $this->command->warn("Aucun élève trouvé. Les inscriptions n'ont pas été créées.");
            return;
        }

        if ($classes->isEmpty()) {
            $this->command->warn("Aucune classe trouvée. Les inscriptions n'ont pas été créées.");
            return;
        }

        $this->command->info("Création des inscriptions pour " . $students->count() . " élèves...");

        foreach ($students as $student) {
            $classe = $classes->random();
            $niveau = $classe->niveau;
            $cycle = $niveau ? $niveau->cycle : null;

            if ($niveau && $cycle) {
                Inscription::updateOrCreate([
                    'student_id' => $student->id,
                    'annee_scolaire_id' => $anneeScolaire->id,
                ], [
                    'cycle_id' => $cycle->id,
                    'niveau_id' => $niveau->id,
                    'classe_id' => $classe->id,
                    'status' => 'inscrite',
                    'ecole_id' => $student->ecole_id ?? $classe->ecole_id,
                ]);
            }
        }
        $this->command->info("Inscriptions terminées.");
    }
}
