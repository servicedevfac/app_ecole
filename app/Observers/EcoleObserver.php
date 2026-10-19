<?php

namespace App\Observers;

use App\Models\Ecole;
use App\Models\Cycle;
use App\Models\Niveau;
use App\Models\Classe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EcoleObserver
{
    /**
     * Handle the Ecole "created" event.
     */
    public function created(Ecole $ecole): void
    {
        $config = [
            'Primaire' => [
                'CP1', 'CP2', 'CE1', 'CE2', 'CM1', 'CM2'
            ],
            'Collège' => [
                '6ème', '5ème', '4ème', '3ème'
            ],
            'Lycée' => [
                '2nde', '1ère', 'Terminale'
            ],
        ];

        try {
            DB::transaction(function () use ($ecole, $config) {
                foreach ($config as $cycleName => $niveaux) {
                    $cycle = Cycle::create([
                        'nom' => $cycleName,
                        'ecole_id' => $ecole->id,
                    ]);

                    foreach ($niveaux as $niveauNom) {
                        $niveau = Niveau::create([
                            'nom' => $niveauNom,
                            'cycle_id' => $cycle->id,
                            'ecole_id' => $ecole->id,
                        ]);

                        Classe::create([
                            'nom' => $niveauNom, // One class per level, named after the level
                            'niveau_id' => $niveau->id,
                            'ecole_id' => $ecole->id,
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'initialisation de l'école {$ecole->id}: " . $e->getMessage());
            // We don't throw here to avoid breaking the school creation, 
            // but the transaction ensures we don't have partial data.
            // Actually, if it fails, maybe we SHOULD throw so the user knows?
            // But the school itself might be created already if this is 'created' event.
            // In Laravel, if 'created' observer fails, the record is already in DB.
            throw $e; 
        }
    }
}
