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

        foreach ($tenants as $tenant) {
            // فعّل التينانت
            tenancy()->initialize($tenant);
            app(PermissionRegistrar::class)->setPermissionsTeamId($tenant->id);

            // جيب أول يوزر مركزي (ممكن تعدله لإيميل محدد)
            $user = User::first();
            if (! $user) continue;

            // اربط المستخدم بالتينانت لو مش موجود
            TenantUser::firstOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'user_id'   => $user->id,
                ],
                [
                    'status' => 'active',
                    'locale' => 'en',
                ]
            );

            // أنشئ رول admin في التينانت لو مش موجود
            $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

            // اسند الرول للمستخدم داخل التينانت الحالي
            if (! $user->hasRole('admin')) {
                $user->assignRole('admin');
            }
        }

        tenancy()->end();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
