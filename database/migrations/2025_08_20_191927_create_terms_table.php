<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_terms_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('school_year_id')->constrained('school_years')->cascadeOnDelete();

            $table->string('name'); // Term 1, Term 2...
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique(['tenant_id', 'school_year_id', 'name'], 'uq_terms_tenant_year_name');
        });
    }
    public function down(): void {
        Schema::dropIfExists('terms');
    }
};
