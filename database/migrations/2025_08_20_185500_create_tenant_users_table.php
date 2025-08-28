<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenant_users', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_tenantusers_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()
                  ->constrained('branches')->nullOnDelete();

            $table->string('status')->default('active');  // active/inactive
            $table->string('locale')->nullable();         // e.g. ar/en
            $table->json('meta')->nullable();             // any per-tenant settings
            $table->timestamps();

            $table->unique(['tenant_id', 'user_id'], 'uq_tenantusers_tenant_user');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_users');
    }
};
