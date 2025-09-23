<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // مركزي
        $this->call([
            TenantSeeder::class,
            CentralUserSeeder::class,
            RoleSeeder::class,             // ينشئ أدوار عامة/مركزية أو يضبط teamId حسب الحاجة
            TenantAdminSeeder::class,      // يربط Admin لكل Tenant
        ]);

        // جوه كل Tenant
        $tenants = Tenant::all();
        foreach ($tenants as $tenant) {
            $tenant->run(function () {
                $this->call([
                    SchoolSeeder::class,
                    BranchSeeder::class,
                    GuardianSeeder::class,
                    TeacherSeeder::class,
                    StudentSeeder::class,
                    ClassroomSeeder::class,
                    SubjectSeeder::class,
                    EnrollmentSeeder::class,
                    FeeItemSeeder::class,
                    InvoiceSeeder::class,
                    PaymentSeeder::class,
                    TenantPermissionsSeeder::class,       // لو عندك صلاحيات مفصلة لكل تينانت
                    TenantRolesPermissionsSeeder::class,   // ربط Roles<->Perms داخل التينانت
                ]);
            });
        }
    }
}
