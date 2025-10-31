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
            $table->uuid('tenant_id')->index();
            $table->uuid('branch_id')->nullable()->index();
            $table->unsignedBigInteger('organization_id')->nullable()->index();

            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();

            $table->enum('visit_type', ['OPD', 'ER', 'IPD'])->default('OPD');
            $table->string('chief_complaint')->nullable();
            $table->json('vitals')->nullable(); // {bp:"120/80", hr:80, temp:37}
            $table->text('notes')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encounters');
    }
};
