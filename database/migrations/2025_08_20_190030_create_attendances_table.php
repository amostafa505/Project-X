<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_attendances_tenant')
                  ->references('id')->on('tenants')
                  ->cascadeOnDelete();

            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->date('date');
            $table->string('status'); // present/absent/late
            $table->string('note')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'student_id', 'date'], 'uq_att_tenant_student_date');
        });
    }
    public function down(): void {
        Schema::dropIfExists('attendances');
    }
};
