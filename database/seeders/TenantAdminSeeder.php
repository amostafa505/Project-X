<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
use App\Models\TenantUser;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class TenantAdminSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::all();
        $user = User::first();
        if (!$user) return;

        foreach ($tenants as $tenant) {
            // فعّل سياق التينانت + الفريق (Spatie Teams)
            tenancy()->initialize($tenant);
            app(PermissionRegistrar::class)->setPermissionsTeamId($tenant->id);

            // اربط المستخدم بالتينانت
            TenantUser::firstOrCreate(
                ['tenant_id' => $tenant->id, 'user_id' => $user->id],
                ['status' => 'active', 'locale' => 'en']
            );

            // أنشئ/ثبت دور admin داخل هذا التينانت بالتحديد
            $adminRole = Role::firstOrCreate(
                ['name' => 'admin', 'guard_name' => 'web', 'tenant_id' => $tenant->id],
                []
            );

            // اسناد الدور داخل نفس التينانت (يعتمد على teamId الحالي)
            if (!$user->hasRole('admin')) {
                $user->assignRole('admin');
            }
        }

        tenancy()->end();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
