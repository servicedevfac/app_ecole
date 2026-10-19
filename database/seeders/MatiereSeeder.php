<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matieres = [
            ['nom' => 'Mathématiques', 'code' => 'MATH-001'],
            ['nom' => 'Français', 'code' => 'FRAN-001'],
            ['nom' => 'Histoire-Géographie', 'code' => 'HIST-001'],
            ['nom' => 'Sciences de la Vie et de la Terre', 'code' => 'SVT-001'],
            ['nom' => 'Physique-Chimie', 'code' => 'PHYS-001'],
            ['nom' => 'Anglais', 'code' => 'ANGL-001'],
            ['nom' => 'Arts Plastiques', 'code' => 'ARTS-001'],
            ['nom' => 'Musique', 'code' => 'MUSI-001'],
            ['nom' => 'Éducation Physique et Sportive', 'code' => 'EPS-001'],
            ['nom' => 'Informatique', 'code' => 'INFO-001'],
        ];

        foreach ($matieres as $matiere) {
            \App\Models\Matiere::firstOrCreate($matiere);
        }
    }
}
