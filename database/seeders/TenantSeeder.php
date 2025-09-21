<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // $user = User::first();
        // if (!$user) {
        //     // يا إمّا تعمل Create ليوزر افتراضي هنا، يا إمّا تسيبها ترجع.
        //     return;
        // }

        // $centralId = config('app.central_tenant_id', '00000000-0000-0000-0000-000000000000');
        $ownerId = User::value('id');

        // attributes = مفاتيح التمييز (id أو code)
        // values = باقي الأعمدة التي تُحدّث عند التحديث
        $tenant = \App\Models\Tenant::updateOrCreate(
            ['code' => 'cnt_000'],
            [
                'id'            => '00000000-0000-0000-0000-000000000000',
                'name'          => 'Central',
                'type'          => 'school',
                'plan'          => 'free',
                'currency'      => 'EGP',
                'locale'        => 'ar',
                'timezone'      => 'Africa/Cairo',
                'status'        => 'active',
                'owner_user_id' => \App\Models\User::value('id'),
            ]
        );

        // بعد ما تتأكد إن جدول domains مضبوط:
        $tenant->domains()->updateOrCreate(
            ['domain' => 'project-x.test'],
            ['is_primary' => true]
        );

        // Organization اختياري
        Organization::firstOrCreate(
            ['name' => 'Central Tenant'],
            ['owner_user_id' => $ownerId]
        );
    }
}
