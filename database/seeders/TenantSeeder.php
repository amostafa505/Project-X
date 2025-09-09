<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // Create a deterministic tenant id (optional)
        $tenant = Tenant::firstOrCreate(
            ['id' => '11111111-1111-1111-1111-111111111111',
                'name' => 'Central'],
            [] // any initial data bag if you use it
        );

        // Attach domain (central DB table)
        $tenant->domains()->firstOrCreate([
            'domain' => 'project-x.test',
        ]);
    }
}
