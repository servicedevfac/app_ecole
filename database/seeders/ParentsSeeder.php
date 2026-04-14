<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ecoleId = \App\Tenant\TenantManager::getEcoleId();
        \App\Models\Parents::factory()->count(20)->create([
            'ecole_id' => $ecoleId
        ]);
    }
}
