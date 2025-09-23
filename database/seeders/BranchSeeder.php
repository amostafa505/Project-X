<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\School;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();
        Branch::factory()->count(2)->create([
            'tenant_id' => tenant('id'),
            'school_id' => $school->id,
        ]);
    }
}
