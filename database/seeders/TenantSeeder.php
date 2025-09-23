<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Organization;
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organization::firstOrCreate(['name' => 'Central Org']);

        $tenant = Tenant::firstOrCreate(
            ['code' => 'TNT-001'],
            [
                'id'         => (string) Str::uuid(),
                'name'       => 'tenant1',
                'type'       => 'school',
                'organization_id' => $org->id,
                'plan'       => 'free',
                'currency'   => 'EGP',
                'locale'     => 'ar',
                'timezone'   => 'Africa/Cairo',
                'status'     => 'active',
                'data'       => [],
                'meta'       => [],
            ],
        );

        // دومين أساسي
        $tenant->domains()->updateOrCreate(
            ['domain' => 'tenant1.project-x.test'],
            ['is_primary' => true],
        );
    }
}
