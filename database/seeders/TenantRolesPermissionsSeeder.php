<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class TenantRolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            tenancy()->initialize($tenant);
            app(PermissionRegistrar::class)->setPermissionsTeamId($tenant->id);

            $perms = [
                'schools.view','schools.create','schools.update','schools.delete',
                'branches.view','branches.create','branches.update','branches.delete',
            ];

            foreach ($perms as $p) {
                Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
            }

            $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
            $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
            $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);

            $admin->givePermissionTo($perms);
            $manager->syncPermissions([
                'schools.view','schools.create','schools.update',
                'branches.view','branches.create','branches.update',
            ]);
            $staff->syncPermissions(['schools.view','branches.view']);
        }

        tenancy()->end();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
