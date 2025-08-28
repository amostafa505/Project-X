<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Classroom;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students   = Student::all();
        $classroom  = Classroom::first();

        foreach ($students as $student) {
            Enrollment::create([
                'tenant_id'   => tenant()->id,
                'student_id'  => $student->id,
                'classroom_id'=> $classroom->id,
                'start_date'  => now(),
                'status'      => 'active',
            ]);
        }
    }
}
