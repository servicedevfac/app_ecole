<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $primaire = \App\Models\Cycle::where('nom', 'Primaire')->first();
        $college = \App\Models\Cycle::where('nom', 'Collège')->first();
        $lycee = \App\Models\Cycle::where('nom', 'Lycée')->first();

        if ($primaire) {
            foreach (['CI', 'CP', 'CE1', 'CE2', 'CM1', 'CM2'] as $nom) {
                \App\Models\Niveau::firstOrCreate(['nom' => $nom, 'cycle_id' => $primaire->id]);
            }
        }

        if ($college) {
            foreach (['6ème', '5ème', '4ème', '3ème'] as $nom) {
                \App\Models\Niveau::firstOrCreate(['nom' => $nom, 'cycle_id' => $college->id]);
            }
        }

        if ($lycee) {
            foreach (['Seconde', 'Première', 'Terminale'] as $nom) {
                \App\Models\Niveau::firstOrCreate(['nom' => $nom, 'cycle_id' => $lycee->id]);
            }
        }
    }
}
