<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\inscription>
 */
class InscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Student::factory(),
            'annee_scolaire_id' => \App\Models\Annee_scolaire::factory(),
            'cycle_id' => \App\Models\Cycle::factory(),
            'niveau_id' => \App\Models\Niveau::factory(),
            'classe_id' => \App\Models\Classe::factory(),
            'status' => 'inscrite',
        ];
    }
}
