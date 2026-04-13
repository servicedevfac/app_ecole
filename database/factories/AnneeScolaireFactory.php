<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annee_scolaire>
 */
class AnneeScolaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = $this->faker->unique()->numberBetween(2023, 2026);
        return [
            'annee' => $year . '-' . ($year + 1),
            'date_debut' => $year . '-09-01',
            'date_fin' => ($year + 1) . '-06-30',
            'status' => 'actif',
        ];
    }
}
