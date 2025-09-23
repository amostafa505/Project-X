<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\School;
use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $branch   = Branch::first();
        $guardian = Guardian::first();
        $school   = School::first();

        Student::factory()->count(10)->create([
            'tenant_id'   => tenant('id'),
            'branch_id'   => $branch->id,
            'guardian_id' => $guardian->id,
            'school_id'   => $school->id,
        ]);
    }
}
