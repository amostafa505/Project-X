<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Branch;
use App\Models\Guardian;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        $first = $this->faker->firstName();
        $last  = $this->faker->lastName();

        return [
            'tenant_id'   => (function_exists('tenant') && tenant()) ? tenant('id') : null,
            'branch_id'   => Branch::factory(),
            'guardian_id' => Guardian::factory(),
            'first_name'  => $first,
            'last_name'   => $last,
            'gender'      => $this->faker->randomElement(['male','female']),
            'dob'         => $this->faker->dateTimeBetween('-18 years', '-5 years'),
            // 'admission_no'=> strtoupper($this->faker->bothify('ADM-#####')),
            'status'      => 'active',
        ];
    }
}
