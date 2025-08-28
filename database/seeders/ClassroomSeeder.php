<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\Branch;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::first();
        Classroom::factory()->count(2)->create(['branch_id' => $branch->id]);
    }
}
