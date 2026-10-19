<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Periode>
 */
class PeriodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->randomElement(['1er Trimestre', '2ème Trimestre', '3ème Trimestre']),
            'type' => 'trimestre',
            'date_debut' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
            'annee_scolaire_id' => \App\Models\Annee_scolaire::factory(),
            'status' => 'ouvert',
        ];
    }
}
