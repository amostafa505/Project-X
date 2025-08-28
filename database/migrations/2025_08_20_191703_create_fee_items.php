<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('fee_items', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_feeitems_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()
                  ->constrained('branches')->nullOnDelete();

            $table->string('name');
            $table->string('code')->nullable();
            $table->decimal('default_amount', 12, 2)->default(0);
            $table->string('currency', 3)->default('EGP');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique(['tenant_id', 'code'], 'uq_feeitems_tenant_code');
        });
    }
    public function down(): void {
        Schema::dropIfExists('fee_items');
    }
};
