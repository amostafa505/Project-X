<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Guardian;

class GuardianFactory extends Factory
{
    protected $model = Guardian::class;

    public function definition(): array
    {
        $name = $this->faker->name();

        return [
            'tenant_id' => (function_exists('tenant') && tenant()) ? tenant('id') : null,
            'name'      => $name,
            'email'     => $this->faker->unique()->safeEmail(),
            'phone'     => $this->faker->optional()->phoneNumber(),
            'relation'  => $this->faker->randomElement(['father','mother','guardian']),
        ];
    }
}
