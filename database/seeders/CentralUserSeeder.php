<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Seeder;

class CentralUserSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ ثبّت team_id المركزي قبل أي عمليات Role/Assign
        app(PermissionRegistrar::class)->setPermissionsTeamId('00000000-0000-0000-0000-000000000000');

        // ✅ أنشئ اليوزر المركزي
        $user = User::firstOrCreate(
            ['email' => 'admin@projectx.test'],
            ['name' => 'Central Admin', 'password' => bcrypt('password')]
        );

        // ✅ أنشئ الدور المركزي فقط (بدون tenant فعلي)
        $role = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
            'tenant_id' => '00000000-0000-0000-0000-000000000000', // احفظه كمركزي
        ]);

        // ✅ اربط اليوزر بالدور ضمن نفس team id
        if (!$user->hasRole('Super Admin')) {
            $user->assignRole($role);
        }

        // ✅ نظّف الكاش
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        app(PermissionRegistrar::class)->setPermissionsTeamId(null);
    }
}
