<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class TenantAdminSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            tenancy()->initialize($tenant);
            app(PermissionRegistrar::class)->setPermissionsTeamId($tenant->id);

            $user = User::firstOrCreate(
                ['email' => "admin+{$tenant->code}@projectx.test"],
                ['name' => "Admin {$tenant->code}", 'password' => bcrypt('password')]
            );

            $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web', 'tenant_id' => $tenant->id]);
            if (!$user->hasRole('admin')) {
                $user->assignRole($role);
            }

            tenancy()->end();
        }

        app(PermissionRegistrar::class)->setPermissionsTeamId(null);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
