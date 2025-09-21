<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('school_years');

        Schema::create('school_years', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_school_years_tenant')
                ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()->index()
                ->constrained('branches')->nullOnDelete();

            $table->string('name');           // e.g. 2025/2026
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->boolean('is_current')->default(false)->index();

            $table->timestamps();

            // unique per tenant(+branch) to avoid duplicates
            $table->unique(['tenant_id', 'branch_id', 'name'], 'uq_school_years_tenant_branch_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_years');
    }
};
