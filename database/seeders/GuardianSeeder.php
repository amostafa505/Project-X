<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guardian;

class GuardianSeeder extends Seeder
{
    public function run(): void
    {
        Guardian::factory()->count(5)->create([
            'tenant_id' => tenant('id'),
        ]);
    }
}
