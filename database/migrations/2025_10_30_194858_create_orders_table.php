<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Multi-tenant scope
            $table->uuid('tenant_id')->index();
            $table->uuid('branch_id')->nullable()->index();
            $table->unsignedBigInteger('organization_id')->nullable()->index();

            // Relations
            $table->foreignId('encounter_id')->nullable()->constrained('encounters')->nullOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();

            // Type (lab / imaging / pharmacy)
            $table->string('type')->index();

            // Translatable fields
            $table->json('title');          // e.g. {"en":"CBC Test","ar":"تحليل دم كامل"}
            $table->json('description')->nullable();

            // Status and meta
            $table->enum('status', ['requested', 'in_progress', 'completed', 'canceled'])->default('requested')->index();
            $table->timestamp('ordered_at')->nullable()->index();
            $table->timestamp('completed_at')->nullable()->index();

            // Optional result / notes (translatable)
            $table->json('results')->nullable();
            $table->json('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
