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
        $guard = 'web';
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            app(PermissionRegistrar::class)->setPermissionsTeamId($tenant->id);

            Role::firstOrCreate(['name' => 'admin',   'guard_name' => $guard, 'tenant_id' => $tenant->id]);
            Role::firstOrCreate(['name' => 'manager', 'guard_name' => $guard, 'tenant_id' => $tenant->id]);
            Role::firstOrCreate(['name' => 'staff',   'guard_name' => $guard, 'tenant_id' => $tenant->id]);
        }

        app(PermissionRegistrar::class)->setPermissionsTeamId(null);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
