<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Stancl\Tenancy\Database\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create or get tenant in central DB
        $tenant = Tenant::firstOrCreate(
            ['id' => '11111111-1111-1111-1111-111111111111'], // fixed UUID for dev
            ['name' => 'Demo School Group']
        );
        // Central user with roles
        $this->call(RoleSeeder::class);
        $this->call(CentralUserSeeder::class);
        $this->call(TenantAdminSeeder::class);
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
