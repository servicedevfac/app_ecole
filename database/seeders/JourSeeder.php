<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horaire;
use App\Models\Jour;


class JourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jours = [
            ['jours' => 'Lundi'],
            ['jours' => 'Mardi'],
            ['jours' => 'Mercredi'],
            ['jours' => 'Jeudi'],
            ['jours' => 'Vendredi'],
            ['jours' => 'Samedi'],
            ['jours' => 'Dimanche'],
        ];
        
       
        foreach ($jours as $jour) {
            Jour::firstOrCreate(
                ['jours' => $jour['jours']],
                $jour
            );
        }

        }
        

       
    
}

