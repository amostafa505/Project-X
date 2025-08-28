<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Branch;
use App\Models\School;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition(): array
    {
        return [
            'tenant_id' => (function_exists('tenant') && tenant()) ? tenant('id') : null,
            'school_id' => School::factory(),
            'name'      => 'Branch ' . $this->faker->citySuffix(),
            'code'      => strtoupper($this->faker->bothify('BR-##')),
            'phone'     => $this->faker->phoneNumber(),
            'address'   => $this->faker->streetAddress(),
            'timezone'  => 'Africa/Cairo',
        ];
    }
}
