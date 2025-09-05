<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Create or get tenant in central DB
        $tenant = Tenant::firstOrCreate(
            ['id' => '11111111-1111-1111-1111-111111111111'], // fixed UUID for dev
            ['name' => 'First School Group']                  // ← أصلحنا الاسم هنا
        );

        // 2) Seed roles for ALL tenants (or at least this one) with proper tenant_id
        //    RoleSeeder internally should loop tenants and set team id (شوف نسخة RoleSeeder تحت)
        $this->call(RoleSeeder::class);

        // 3) Central-only seeders (تشتغل على الداتا المركزية)
        $this->call(CentralUserSeeder::class);
        $this->call(TenantAdminSeeder::class);

        // 4) Tenant DB seeders (دي جوه tenant connection)
        $tenant->run(function () {
            $this->call([
                SchoolSeeder::class,
                BranchSeeder::class,
                TeacherSeeder::class,
                GuardianSeeder::class,
                StudentSeeder::class,
                ClassroomSeeder::class,
                SubjectSeeder::class,
                EnrollmentSeeder::class,
                FeeItemSeeder::class,
                InvoiceSeeder::class,
                PaymentSeeder::class,
            ]);
        });
    }
}
