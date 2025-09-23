<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        School::factory()->count(1)->create([
            'tenant_id' => tenant('id'),
        ]);
    }
}
