<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matiere>
 */
class MatiereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->unique()->randomElement([
                'Mathématiques', 'Français', 'Histoire-Géo', 'Sciences', 'Anglais', 
                'Espaces Verts', 'Arts Plastiques', 'Musique', 'EPS', 'Informatique'
            ]),
            'code' => $this->faker->unique()->bothify('MAT-###'),
        ];
    }
}
