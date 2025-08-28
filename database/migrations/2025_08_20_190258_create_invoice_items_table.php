<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_inv_items_tenant')
                  ->references('id')->on('tenants')
                  ->cascadeOnDelete();

            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();

            $table->string('item');
            $table->unsignedInteger('qty')->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('line_total', 12, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('invoice_items');
    }
};
