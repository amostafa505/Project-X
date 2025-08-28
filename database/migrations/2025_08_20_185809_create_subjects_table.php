<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_subjects_tenant')
                  ->references('id')->on('tenants')
                  ->cascadeOnDelete();

            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();

            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'branch_id', 'code'], 'uq_subjects_tenant_branch_code');
        });
    }
    public function down(): void {
        Schema::dropIfExists('subjects');
    }
};
