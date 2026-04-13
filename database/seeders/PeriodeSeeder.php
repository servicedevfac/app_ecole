<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anneeScolaire = \App\Models\Annee_scolaire::where('status', 'actif')->first();
        if (!$anneeScolaire) return;

        $periodes = [
            ['nom' => '1er Trimestre', 'type' => 'trimestre', 'date_debut' => '2025-09-01', 'date_fin' => '2025-12-20'],
            ['nom' => '2ème Trimestre', 'type' => 'trimestre', 'date_debut' => '2026-01-05', 'date_fin' => '2026-03-31'],
            ['nom' => '3ème Trimestre', 'type' => 'trimestre', 'date_debut' => '2026-04-01', 'date_fin' => '2026-06-30'],
        ];

        foreach ($periodes as $periode) {
            \App\Models\Periode::firstOrCreate(array_merge($periode, ['annee_scolaire_id' => $anneeScolaire->id, 'status' => 'ouvert']));
        }
    }
}
