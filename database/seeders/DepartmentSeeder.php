<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = function_exists('tenant') && tenant() ? tenant('id') : null;

        $items = [
            ['en' => 'Emergency', 'ar' => 'الطوارئ'],
            ['en' => 'Outpatient', 'ar' => 'العيادات الخارجية'],
            ['en' => 'Inpatient', 'ar' => 'الدخول الداخلي'],
            ['en' => 'ICU', 'ar' => 'العناية المركزة'],
            ['en' => 'Laboratory', 'ar' => 'المعمل'],
            ['en' => 'Radiology', 'ar' => 'الأشعة'],
            ['en' => 'Pharmacy', 'ar' => 'الصيدلية']
        ];

        foreach ($items as $i => $name) {
            Department::create([
                'tenant_id'   => $tenantId,
                'name'        => $name,
                'description' => ['en' => 'Default department', 'ar' => 'قسم افتراضي'],
                'code'        => 'DEP' . str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                'is_active'   => true,
            ]);
        }
    }
}
