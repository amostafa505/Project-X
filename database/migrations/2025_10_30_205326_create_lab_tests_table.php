<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();

            // Multi-tenant scope
            $table->uuid('tenant_id')->index();
            $table->uuid('branch_id')->nullable()->index();
            $table->unsignedBigInteger('organization_id')->nullable()->index();

            // Translatable fields
            $table->json('name'); // {"en":"CBC","ar":"تحليل دم كامل"}
            $table->json('description')->nullable();

            // Optional grouping (like Hematology, Chemistry...)
            $table->json('category')->nullable();

            // Optional reference code or external lab code
            $table->string('code')->nullable()->unique();

            // Reference values or ranges
            $table->json('reference_range')->nullable();
            // Example: {"male":"13-17 g/dL","female":"12-15 g/dL"}

            // Units (e.g. mg/dl)
            $table->string('unit')->nullable();

            // Default price for billing
            $table->decimal('price', 10, 2)->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
    }
};
