<?php

namespace Database\Seeders;

use App\Models\Annee_scolaire;
use App\Models\Classe;
use App\Models\Cycle;
use App\Models\Ecole;
use App\Models\Enseignant;
use App\Models\Inscription;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\Student;
use App\Models\User;
use App\Models\affectations_pedagogiques;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RealSimulatedResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake('fr_FR');

        // 1. Créer une école complète
        $ecole = Ecole::firstOrCreate([
            'email' => 'contact@excellence-moderne.edu',
        ], [
            'nom' => 'Lycée Excellence Moderne',
            'telephone' => '+225 0102030405',
            'adresse' => 'Cocody, Abidjan, Côte d\'Ivoire',
            'status' => 'active',
        ]);

        \App\Tenant\TenantManager::setEcoleId($ecole->id);

        $prefix = "LXM-"; // Prefix to ensure uniqueness

        // 2. Créer une année scolaire active
        $anneeScolaire = Annee_scolaire::firstOrCreate([
            'annee' => '2023-2024',
            'ecole_id' => $ecole->id,
        ], [
            'date_debut' => '2023-09-15',
            'date_fin' => '2024-06-30',
            'status' => 'actif',
        ]);

        // 3. Créer des Cycles et Niveaux
        $cyclesData = [
            'Primaire' => ['CP1', 'CP2', 'CE1', 'CE2', 'CM1', 'CM2'],
            'Collège' => ['6ème', '5ème', '4ème', '3ème'],
            'Lycée' => ['2nde', '1ère', 'Tle'],
        ];

        $allNiveaux = [];
        foreach ($cyclesData as $cycleNom => $niveauxNoms) {
            $cycle = Cycle::firstOrCreate([
                'nom' => $cycleNom,
                'ecole_id' => $ecole->id,
            ]);

            foreach ($niveauxNoms as $niveauNom) {
                $allNiveaux[] = Niveau::firstOrCreate([
                    'nom' => $niveauNom,
                    'cycle_id' => $cycle->id,
                    'ecole_id' => $ecole->id,
                ]);
            }
        }

        // 4. Créer 14 classes
        $classes = [];
        for ($i = 0; $i < 14; $i++) {
            $niveau = $allNiveaux[$i % count($allNiveaux)];
            $suffix = ($i >= count($allNiveaux)) ? ' B' : ' A';
            $classes[] = Classe::firstOrCreate([
                'nom' => $niveau->nom . $suffix,
                'niveau_id' => $niveau->id,
                'ecole_id' => $ecole->id,
            ]);
        }

        // 5. Créer 7 matières
        $matieresData = [
            ['nom' => 'Mathématiques', 'code' => $prefix.'MATH'],
            ['nom' => 'Français', 'code' => $prefix.'FRAN'],
            ['nom' => 'Anglais', 'code' => $prefix.'ANGL'],
            ['nom' => 'Histoire-Géographie', 'code' => $prefix.'HG'],
            ['nom' => 'SVT', 'code' => $prefix.'SVT'],
            ['nom' => 'Physique-Chimie', 'code' => $prefix.'PC'],
            ['nom' => 'Education Physique et Sportive', 'code' => $prefix.'EPS'],
        ];

        $matieres = [];
        foreach ($matieresData as $mData) {
            $matieres[] = Matiere::firstOrCreate([
                'code' => $mData['code'],
                'ecole_id' => $ecole->id,
            ], [
                'nom' => $mData['nom'],
            ]);
        }

        // Appliquer coefficients (ex: entre 2 et 5)
        foreach ($classes as $classe) {
            foreach ($matieres as $matiere) {
                if (!$classe->matieres()->where('matiere_id', $matiere->id)->exists()) {
                    $coeff = rand(2, 5);
                    $classe->matieres()->attach($matiere->id, ['coefficient' => $coeff, 'ecole_id' => $ecole->id]);
                }
            }
        }

        // 6. Créer 15 enseignants
        $enseignants = [];
        for ($i = 1; $i <= 15; $i++) {
            $user = User::firstOrCreate([
                'email' => "teacher{$i}_lxm@excellence.edu",
            ], [
                'name' => $faker->name,
                'password' => Hash::make('password'),
                'ecole_id' => $ecole->id,
            ]);
            
            if (!$user->hasRole('enseignant')) {
                $user->assignRole('enseignant');
            }

            $enseignants[] = Enseignant::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'nom' => explode(' ', $user->name)[1] ?? $user->name,
                'prenom' => explode(' ', $user->name)[0],
                'email' => $user->email,
                'telephone' => $faker->phoneNumber,
                'specialite' => $matieres[array_rand($matieres)]->nom,
                'statut' => 'actif',
                'ecole_id' => $ecole->id,
            ]);
        }

        // 7. Créer 280 élèves
        $students = [];
        for ($i = 1; $i <= 280; $i++) {
            $students[] = Student::firstOrCreate([
                'email' => "student{$i}_lxm@excellence.edu",
            ], [
                'nom' => $faker->lastName,
                'prenom' => $faker->firstName,
                'sexe' => $faker->randomElement(['M', 'F']),
                'date_naissance' => $faker->date('Y-m-d', '2015-01-01'),
                'status' => 'actif',
                'ecole_id' => $ecole->id,
            ]);
        }

        // 8. Inscriptions cohérentes (20 élèves par classe environ)
        foreach ($students as $index => $student) {
            $classe = $classes[$index % count($classes)];
            Inscription::firstOrCreate([
                'student_id' => $student->id,
                'annee_scolaire_id' => $anneeScolaire->id,
            ], [
                'classe_id' => $classe->id,
                'niveau_id' => $classe->niveau_id,
                'cycle_id' => $classe->niveau->cycle_id,
                'status' => 'inscrite',
                'ecole_id' => $ecole->id,
            ]);
        }

        // 9. Affectations pédagogiques cohérentes
        foreach ($classes as $classe) {
            foreach ($matieres as $matiere) {
                affectations_pedagogiques::firstOrCreate([
                    'matiere_id' => $matiere->id,
                    'classe_id' => $classe->id,
                    'annee_scolaire_id' => $anneeScolaire->id,
                ], [
                    'enseignant_id' => $enseignants[array_rand($enseignants)]->id,
                    'ecole_id' => $ecole->id,
                ]);
            }
        }
    }
}
