<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ecole>
 */
class EcoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nom = fake()->company();
        return [
            'nom' => $nom,
            'slug' => Str::slug($nom),
            'email' => fake()->unique()->companyEmail(),
            'telephone' => fake()->phoneNumber(),
            'adresse' => fake()->address(),
            'is_active' => true,
        ];
    }
}
