<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'admin',
            'enseignant',
            'etudiant',
            'parent',
            'staff',
        ];

        foreach ($roles as $name) {
            \Spatie\Permission\Models\Role::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }
    }
}

