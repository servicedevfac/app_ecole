<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnseignantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Enseignant::factory()->count(10)->create()->each(function ($enseignant) {
            $user = \App\Models\User::find($enseignant->user_id);
            if ($user) {
                $user->assignRole('enseignant');
            }
        });
    }
}
