<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. S'assurer qu'au moins une école existe pour l'assigner aux données de test
        $this->call(EcoleSeeder::class);
        $ecole = \App\Models\Ecole::first();
        
        if ($ecole) {
            \App\Tenant\TenantManager::setEcoleId($ecole->id);
        }

        // 2. Exécuter les autres seeders
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            CycleSeeder::class,
            NiveauSeeder::class,
            ClasseSeeder::class,
            AnneeScolaireSeeder::class,
            ParentsSeeder::class,
            RelationSeeder::class,
            StudentSeeder::class,
            InscriptionSeeder::class,
            MatiereSeeder::class,
            EnseignantSeeder::class,
            AffectationPedagogiqueSeeder::class,
            PeriodeSeeder::class,
            EvaluationSeeder::class,
            JourSeeder::class,
            HoraireSeeder::class,
        ]);

        // Créer un utilisateur administrateur de test
        $admin = \App\Models\User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Admin Test',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'ecole_id' => $ecole ? $ecole->id : null,
        ]);
        $admin->assignRole('Super Admin');
    }
}
