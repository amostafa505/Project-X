<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\School;

class SchoolFactory extends Factory
{
    protected $model = School::class;

    public function definition(): array
    {
        return [
            'tenant_id' => (function_exists('tenant') && tenant()) ? tenant('id') : null,
            'name'      => $this->faker->company() . ' School',
            'code'      => strtoupper($this->faker->bothify('SCH-###')),
            'phone'     => $this->faker->phoneNumber(),
            'address'   => $this->faker->address(),
            'status'    => 'active',
        ];
    }
}
