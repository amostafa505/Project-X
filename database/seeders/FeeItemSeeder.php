<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\FeeItem;
use Illuminate\Database\Seeder;

class FeeItemSeeder extends Seeder
{

    public function run(): void
    {
        $tenants = Tenant::first();
        FeeItem::insert([
            ['tenant_id' => $tenants->id, 'name' => 'Tuition', 'code' => 'TUIT', 'default_amount' => 1000, 'currency' => 'EGP', 'active' => 1],
            ['tenant_id' => $tenants->id, 'name' => 'Books',   'code' => 'BOOK', 'default_amount' => 300,  'currency' => 'EGP', 'active' => 1],
        ]);
    }
}
