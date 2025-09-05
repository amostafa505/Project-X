<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class CentralUserSeeder extends Seeder
{
    public function run(): void
    {
        // أنشئ/هات المستخدم المركزي
        $user = User::firstOrCreate(
            ['email' => 'admin@projectx.test'],
            ['name' => 'Central Admin', 'password' => bcrypt('password')]
        );

        $central = centralTenantId();
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($central);
        // إسناد الرول المركزي
        $user->syncRoles(['Super Admin']); // أو assignRole('Super Admin')

        // تنظيف الكاش
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
