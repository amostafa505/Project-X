<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital\Doctor;
use App\Models\Hospital\Patient;
use App\Models\Hospital\Appointment;

class HospitalQuickSeed extends Seeder
{
    public function run(): void
    {
        $tenantId = function_exists('tenant') && tenant() ? tenant('id') : null;

        $d1 = Doctor::create(['tenant_id' => $tenantId, 'first_name' => 'Omar', 'last_name' => 'Hassan', 'specialty' => 'Cardiology', 'is_active' => true]);
        $d2 = Doctor::create(['tenant_id' => $tenantId, 'first_name' => 'Mona', 'last_name' => 'Ali', 'specialty' => 'Pediatrics', 'is_active' => true]);

        $p1 = Patient::create(['tenant_id' => $tenantId, 'mrn' => 'MRN-1001', 'first_name' => 'Ahmed', 'last_name' => 'Mostafa', 'gender' => 'male']);
        $p2 = Patient::create(['tenant_id' => $tenantId, 'mrn' => 'MRN-1002', 'first_name' => 'Sara', 'last_name' => 'Mahmoud', 'gender' => 'female']);

        Appointment::create(['tenant_id' => $tenantId, 'patient_id' => $p1->id, 'doctor_id' => $d1->id, 'scheduled_at' => now()->addHour(), 'status' => 'booked']);
        Appointment::create(['tenant_id' => $tenantId, 'patient_id' => $p2->id, 'doctor_id' => $d2->id, 'scheduled_at' => now()->addDays(1)->setTime(10, 0), 'status' => 'booked']);
    }
}
