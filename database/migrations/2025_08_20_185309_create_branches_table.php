<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_branches_tenant')
                  ->references('id')->on('tenants')
                  ->cascadeOnDelete();

            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();

            $table->string('name');
            $table->string('code')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('timezone')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'school_id', 'code'], 'uq_branches_tenant_school_code');
        });
    }
    public function down(): void {
        Schema::dropIfExists('branches');
    }
};
