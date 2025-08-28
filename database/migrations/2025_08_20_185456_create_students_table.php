<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_students_tenant')
                  ->references('id')->on('tenants')
                  ->cascadeOnDelete();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('guardian_id')->nullable()->constrained('guardians')->nullOnDelete();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('code')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable(); // m/f
            $table->string('status')->default('active');
            $table->timestamps();

            $table->unique(['tenant_id', 'code'], 'uq_students_tenant_code');
        });
    }
    public function down(): void {
        Schema::dropIfExists('students');
    }
};
