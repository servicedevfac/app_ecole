<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parents = \App\Models\Parents::all();
        $students = \App\Models\Student::all();

        if ($parents->isEmpty() || $students->isEmpty()) return;

        foreach ($students as $student) {
            $parent = $parents->random();
            \App\Models\Relation::firstOrCreate([
                'parent_id' => $parent->id,
                'student_id' => $student->id,
            ], [
                'relation' => 'Père/Mère',
            ]);
        }
    }
}
