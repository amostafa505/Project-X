<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('terms');

        Schema::create('terms', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_terms_tenant')
                ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()->index()
                ->constrained('branches')->nullOnDelete();

            $table->foreignId('school_year_id')->constrained('school_years')->cascadeOnDelete();

            $table->string('name'); // Term 1, Term 2, … or Arabic names
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->boolean('is_current')->default(false)->index();

            $table->timestamps();

            $table->unique(
                ['tenant_id', 'branch_id', 'school_year_id', 'name'],
                'uq_terms_tenant_branch_year_name'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
