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
            ['code' => 'CNT-001'],
            [
                'id'         => '00000000-0000-0000-0000-000000000000',
                'name'       => 'Central',
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
            ['domain' => 'project-x.test'],
            ['is_primary' => true],
        );
    }
}
