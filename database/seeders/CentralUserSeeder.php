<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

class CentralUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@projectx.test'],
            ['name' => 'Central Admin', 'password' => bcrypt('password')]
        );

        // roles/permissions المركزية (لو عندك)
        // $user->syncRoles(['Super Admin']);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
