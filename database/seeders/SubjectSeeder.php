<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $branch   = Branch::first();
        Subject::insert([
            ['tenant_id' => tenant()->id,'branch_id' => $branch->id, 'name' => 'Math', 'code' => 'MATH'],
            ['tenant_id' => tenant()->id,'branch_id' => $branch->id, 'name' => 'English', 'code' => 'ENG'],
            ['tenant_id' => tenant()->id,'branch_id' => $branch->id, 'name' => 'Science', 'code' => 'SCI'],
        ]);
    }
}
