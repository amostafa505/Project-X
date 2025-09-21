<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('enrollments');

        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            // tenancy
            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_enrollments_tenant')
                ->references('id')->on('tenants')->cascadeOnDelete();

            // optional branch scoping
            $table->foreignId('branch_id')->nullable()->index()
                ->constrained('branches')->nullOnDelete();

            // relations
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained('classrooms')->cascadeOnDelete();

            // dates / status
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('active'); // active|completed|withdrawn|paused

            $table->timestamps();

            // avoid duplicate active enrollments for same student-classroom-branch within tenant
            $table->unique(
                ['tenant_id', 'branch_id', 'student_id', 'classroom_id'],
                'uq_enrollments_tenant_branch_student_class'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
