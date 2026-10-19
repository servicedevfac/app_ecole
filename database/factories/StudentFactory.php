<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matricule' => fake()->unique()->bothify('STUD-####'),
            'nom' => fake()->lastName,
            'prenom' => fake()->firstName,
            'sexe' => fake()->randomElement(['M', 'F']),
            'date_naissance' => fake()->date('Y-m-d', '-10 years'),
            'email' => fake()->unique()->safeEmail,
            'phone' => fake()->phoneNumber,
            'address' => fake()->address,
            'status' => 'active',
        ];
    }
}
