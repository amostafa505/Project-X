<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_teachers_tenant')
                  ->references('id')->on('tenants')
                  ->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()
                  ->constrained('branches')->nullOnDelete();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('employee_code')->nullable();
            $table->string('specialization')->nullable();
            $table->string('status')->default('active');
            $table->date('hiring_date')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'email'], 'uq_teachers_tenant_email');
            $table->unique(['tenant_id', 'employee_code'], 'uq_teachers_tenant_code');
        });
    }
    public function down(): void {
        Schema::dropIfExists('teachers');
    }
};
