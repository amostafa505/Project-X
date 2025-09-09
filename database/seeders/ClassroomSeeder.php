<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Classroom;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::first();
        Classroom::factory()
    ->count(2)
    ->state(new Sequence(
        ['name' => 'Class A'],
        ['name' => 'Class B'],
        // زوّد لو هتعمل أكتر من 2
    ))
    ->create([
        'branch_id' => $branch->id,
    ]);
    }
}
