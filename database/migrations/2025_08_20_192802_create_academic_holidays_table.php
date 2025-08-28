<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('academic_holidays', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_holidays_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();

            $table->string('name');
            $table->date('starts_on');
            $table->date('ends_on')->nullable(); // 1-day or range
            $table->boolean('full_day')->default(true);
            $table->string('note')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'school_id', 'starts_on'], 'ix_holidays_tenant_school_start');
        });
    }
    public function down(): void {
        Schema::dropIfExists('academic_holidays');
    }
};
