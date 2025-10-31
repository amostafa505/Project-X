<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('encounters', function (Blueprint $table) {
            $table->id();
            // Multi-tenant scope
            $table->uuid('tenant_id')->index();
            $table->uuid('branch_id')->nullable()->index();
            $table->unsignedBigInteger('organization_id')->nullable()->index();

            // Relations
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();

            // Type
            $table->enum('visit_type', ['OPD', 'ER', 'IPD'])->default('OPD')->index();

            // Translatable clinical text
            $table->json('chief_complaint')->nullable(); // {"en":"...","ar":"..."}
            $table->json('notes')->nullable();           // {"en":"...","ar":"..."}

            // Vitals as JSON (not translatable; simple numeric)
            $table->json('vitals')->nullable(); // {"bp":"120/80","hr":80,"temp":37,"spo2":98,"wt":70,"ht":170}

            // Timestamps for the visit
            $table->dateTime('started_at')->nullable()->index();
            $table->dateTime('ended_at')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encounters');
    }
};
