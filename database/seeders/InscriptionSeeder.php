<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        if (!$anneeScolaire) return;

        foreach ($students as $student) {
            $classe = $classes->random();
            $niveau = $classe->niveau;
            $cycle = $niveau ? $niveau->cycle : null;

            if ($niveau && $cycle) {
                \App\Models\inscription::updateOrCreate([
                    'student_id' => $student->id,
                    'annee_scolaire_id' => $anneeScolaire->id,
                ], [
                    'cycle_id' => $cycle->id,
                    'niveau_id' => $niveau->id,
                    'classe_id' => $classe->id,
                    'status' => 'inscrite',
                ]);
            }
        }
    }
}
