<?php

namespace Database\Seeders;

use App\Models\Horaire;
use Illuminate\Database\Seeder;

class HoraireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Exemple de créneaux horaires par défaut
        $horaires = [
            [
                
                'heure_debut' => '08:00',
                'heure_fin' => '10:00',
                'type' => 'cours',
            
            ],
            [
               
                'heure_debut' => '10:00',
                'heure_fin' => '12:00',
                'type' => 'cours',
            
            ],
            [
              
                'heure_debut' => '12:00',
                'heure_fin' => '13:00',
                'type' => 'pause',
            
            ],
            [
                
                'heure_debut' => '14:00',
                'heure_fin' => '16:00',
                'type' => 'cours',
            
            ],
        ];

        foreach ($horaires as $data) {
            Horaire::firstOrCreate(
                [
                    'heure_debut' => $data['heure_debut'],
                    'heure_fin' => $data['heure_fin'],
                    'type' => $data['type'],
                ],
                $data
            );
        }
    }
}

