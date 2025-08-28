<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use App\Models\Branch;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition(): array
    {
        $name = $this->faker->name();

        return [
            'tenant_id' => (function_exists('tenant') && tenant()) ? tenant('id') : null,
            'branch_id' => Branch::factory(),
            'first_name'      => $name,
            'last_name'        => $name,
            'email'     => $this->faker->unique()->safeEmail(),
            'phone'     => $this->faker->optional()->phoneNumber(),
            'hiring_date'  => $this->faker->dateTimeBetween('-3 years', 'now'),
            'status'    => 'active',
        ];
    }
}
