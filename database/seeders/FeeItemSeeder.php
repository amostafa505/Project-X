<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeeItem;

class FeeItemSeeder extends Seeder
{
    public function run(): void
    {
        FeeItem::insert([
            ['tenant_id' => tenant()->id, 'name' => 'Tuition', 'code' => 'TUIT', 'default_amount' => 1000, 'currency' => 'EGP', 'active' => 1],
            ['tenant_id' => tenant()->id, 'name' => 'Books',   'code' => 'BOOK', 'default_amount' => 300,  'currency' => 'EGP', 'active' => 1],
        ]);
    }
}
