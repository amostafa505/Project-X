<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Multi-tenant scope
            $table->uuid('tenant_id')->index();
            $table->uuid('branch_id')->nullable()->index();
            $table->unsignedBigInteger('organization_id')->nullable()->index();

            // Parent order relation
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();

            // Type (inherits from parent but stored for convenience)
            $table->string('type')->index(); // lab / imaging / pharmacy

            // Translatable name and description
            $table->json('name');         // {"en":"CBC","ar":"تحليل دم كامل"}
            $table->json('description')->nullable();

            // Optional attributes (e.g., dosage, quantity, test code, image type)
            $table->string('code')->nullable()->index();
            $table->string('unit')->nullable(); // mg, ml, tablet, etc.
            $table->decimal('quantity', 8, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();

            // Result (for lab/imaging) – translatable
            $table->json('result')->nullable(); // {"en":"Normal","ar":"طبيعي"}
            $table->json('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
