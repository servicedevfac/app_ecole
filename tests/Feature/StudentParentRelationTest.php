<?php

namespace Tests\Feature;

use App\Models\Parents;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentParentRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_be_attached_to_parent_with_relation_pivot(): void
    {
        $parent = Parents::create([
            'nom' => 'Kouassi',
            'prenom' => 'Marie',
            'email' => 'marie.kouassi@example.test',
            'telephone' => '0102030405',
            'adresse' => 'Yopougon',
        ]);

        $student = Student::create([
            'nom' => 'Djue',
            'prenom' => 'Palmer',
            'date_naissance' => '2012-02-29',
            'email' => 'palmer.djue@example.test',
            'phone' => '0575785003',
            'address' => 'Cité marine',
        ]);

        $student->parents()->attach($parent->id, [
            'relation' => 'mere',
        ]);

        $this->assertDatabaseHas('relations', [
            'student_id' => $student->id,
            'parent_id' => $parent->id,
            'relation' => 'mere',
        ]);

        $student = $student->fresh()->load('parents');

        $this->assertCount(1, $student->parents);
        $this->assertSame('mere', $student->parents->first()->pivot->relation);
    }
}

