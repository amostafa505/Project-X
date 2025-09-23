<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;

class TenantRolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            tenancy()->initialize($tenant);
            app(PermissionRegistrar::class)->setPermissionsTeamId($tenant->id);

            $admin   = Role::findOrCreate('Admin', 'web');
            $manager = Role::findOrCreate('Manager', 'web');
            $staff   = Role::findOrCreate('Staff', 'web');

            $manager->syncPermissions([
                'schools.view', 'schools.create', 'schools.update',
                'branches.view', 'branches.create', 'branches.update',
            ]);
            $staff->syncPermissions(['schools.view', 'branches.view']);

            tenancy()->end();
        }

        app(PermissionRegistrar::class)->setPermissionsTeamId(null);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
