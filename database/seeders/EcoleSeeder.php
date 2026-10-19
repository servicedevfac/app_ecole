<?php

namespace Database\Seeders;

use App\Models\Ecole;
use Illuminate\Database\Seeder;

class EcoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ecole::firstOrCreate([
            'nom' => 'Groupe Scolaire Palmer',
        ], [
            'slug' => 'groupe-scolaire-palmer',
            'email' => 'contact@palmer.com',
            'telephone' => '0123456789',
            'adresse' => '123 Rue de l Education',
            'is_active' => true,
        ]);

        Ecole::firstOrCreate([
            'nom' => 'Académie de l Excellence',
        ], [
            'slug' => 'academie-excellence',
            'email' => 'contact@excellence.com',
            'telephone' => '0987654321',
            'adresse' => '456 Avenue des Savoirs',
            'is_active' => true,
        ]);
    }
}
