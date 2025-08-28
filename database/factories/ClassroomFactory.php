<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classroom;
use App\Models\Branch;

class ClassroomFactory extends Factory
{
    protected $model = Classroom::class;

    public function definition(): array
    {
        return [
            'tenant_id'   => (function_exists('tenant') && tenant()) ? tenant('id') : null,
            'branch_id'   => Branch::factory(),
            'name'        => 'Class ' . $this->faker->randomElement(['A','B','C','D']),
            'grade' => $this->faker->numberBetween(1, 12),
            'section'     => $this->faker->randomElement(['A','B','C']),
        ];
    }
}
