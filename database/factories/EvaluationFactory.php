<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'classe_id' => \App\Models\Classe::factory(),
            'matiere_id' => \App\Models\Matiere::factory(),
            'enseignant_id' => \App\Models\User::factory(),
            'libelle' => $this->faker->sentence(3),
            'type' => $this->faker->randomElement(['Devoir', 'Interrogation', 'Examen']),
            'date_evaluation' => $this->faker->date(),
            'coefficient' => $this->faker->randomElement([1, 2, 3, 4]),
            'note_max' => 20,
            'statut' => 'validee',
            'periode_id' => \App\Models\Periode::factory(),
        ];
    }
}
