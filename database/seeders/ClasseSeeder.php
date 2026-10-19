<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = \App\Models\Niveau::all();
        foreach ($niveaux as $niveau) {
            \App\Models\Classe::firstOrCreate([
                'nom' => $niveau->nom . ' A',
                'niveau_id' => $niveau->id
            ]);
            \App\Models\Classe::firstOrCreate([
                'nom' => $niveau->nom . ' B',
                'niveau_id' => $niveau->id
            ]);
        }
    }
}
