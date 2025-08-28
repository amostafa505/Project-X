<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Classroom;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition(): array
    {
        return [
            'tenant_id'    => (function_exists('tenant') && tenant()) ? tenant('id') : null,
            'student_id'   => Student::factory(),
            'classroom_id' => Classroom::factory(),
            'start_date'   => now()->subDays(fake()->numberBetween(1, 60))->toDateString(),
            'end_date'     => null,
            'status'       => 'active',
        ];
    }
}
