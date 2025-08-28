<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('school_years', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_years_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();

            $table->string('name'); // 2024/2025
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique(['tenant_id', 'school_id', 'name'], 'uq_years_tenant_school_name');
        });
    }
    public function down(): void {
        Schema::dropIfExists('school_years');
    }
};
