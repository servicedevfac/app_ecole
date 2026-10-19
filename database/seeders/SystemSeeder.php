<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Seed the application's essential database records.
     * These are required for the application to function correctly in production.
     */
    public function run(): void
    {
        // 1. Rôles et Permissions
        $this->call([
            RoleSeeder::class,
        ]);

        // 2. Écoles (Données de base ou Minimales)
        $this->call([
            EcoleSeeder::class,
        ]);

        $ecole = \App\Models\Ecole::first();
        if ($ecole) {
            \App\Tenant\TenantManager::setEcoleId($ecole->id);
        }

        // 3. Structure Académique (Indispensable)
        $this->call([
            CycleSeeder::class,
            NiveauSeeder::class,
            MatiereSeeder::class,
            AnneeScolaireSeeder::class,
            JourSeeder::class,
            HoraireSeeder::class,
        ]);

        // 4. Comptes Administrateurs par défaut
        $this->seedAdminUsers($ecole);
    }

    protected function seedAdminUsers($ecole)
    {
        // Super Administrateur (Global)
        $superAdmin = \App\Models\User::firstOrCreate([
            'email' => 'superadmin@admin.com',
        ], [
            'name' => 'Super Admin',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'ecole_id' => null,
        ]);
        $superAdmin->assignRole('Super Admin');

        // Administrateur d'école par défaut
        if ($ecole) {
            $admin = \App\Models\User::firstOrCreate([
                'email' => 'admin@admin.com',
            ], [
                'name' => 'Admin ' . $ecole->nom,
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'ecole_id' => $ecole->id,
            ]);
            $admin->assignRole('admin');
        }
    }
}
