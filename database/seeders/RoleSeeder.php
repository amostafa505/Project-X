<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $guard   = 'web';
        $central = centralTenantId();

        // 3.a رول مركزي على CENTRAL_TENANT_ID
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($central);

        \Spatie\Permission\Models\Role::firstOrCreate([
            'name'       => 'Super Admin',
            'guard_name' => $guard,
            'tenant_id'  => $central,
        ]);

        // 3.b رولز لكل Tenant فعلي (تجنب المركزي لو أضفته في tenants)
        $tenants = \App\Models\Tenant::query()
            ->where('id', '!=', $central) // احترازيًا
            ->get();

        foreach ($tenants as $tenant) {
            app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($tenant->id);

            \Spatie\Permission\Models\Role::firstOrCreate([
                'name'       => 'Super Admin',
                'guard_name' => $guard,
                'tenant_id'  => $tenant->id,
            ]);
            \Spatie\Permission\Models\Role::firstOrCreate([
                'name'       => 'Admin',
                'guard_name' => $guard,
                'tenant_id'  => $tenant->id,
            ]);
            \Spatie\Permission\Models\Role::firstOrCreate([
                'name'       => 'Teacher',
                'guard_name' => $guard,
                'tenant_id'  => $tenant->id,
            ]);
            \Spatie\Permission\Models\Role::firstOrCreate([
                'name'       => 'Student',
                'guard_name' => $guard,
                'tenant_id'  => $tenant->id,
            ]);
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId(null);
    }
}
