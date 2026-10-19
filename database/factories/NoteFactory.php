<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'evaluation_id' => \App\Models\Evaluation::factory(),
            'student_id' => \App\Models\Student::factory(),
            'note' => $this->faker->randomFloat(2, 0, 20),
            'appreciation' => $this->faker->sentence(),
        ];
    }
}
