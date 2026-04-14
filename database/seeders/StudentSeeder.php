<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ecoleId = \App\Tenant\TenantManager::getEcoleId();
        \App\Models\Student::factory()->count(50)->create([
            'ecole_id' => $ecoleId
        ]);
    }
}
