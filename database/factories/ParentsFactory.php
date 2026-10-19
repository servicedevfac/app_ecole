<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\parents>
 */
class ParentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->lastName,
            'prenom' => fake()->firstName,
            'email' => fake()->unique()->safeEmail,
            'telephone' => fake()->phoneNumber,
            'autre_telephone' => fake()->optional()->phoneNumber,
            'adresse' => fake()->address,
        ];
    }
}
