<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Branch;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::first();
        Teacher::factory()->count(5)->create([
            'tenant_id' => tenant('id'),
            'branch_id' => $branch->id,
        ]);
    }
}
