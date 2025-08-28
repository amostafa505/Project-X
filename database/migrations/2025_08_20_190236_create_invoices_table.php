<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_invoices_tenant')
                  ->references('id')->on('tenants')
                  ->cascadeOnDelete();

            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->string('number');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('EGP');
            $table->string('status')->default('draft'); // draft/issued/paid/void
            $table->date('due_date')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'number'], 'uq_invoices_tenant_number');
        });
    }
    public function down(): void {
        Schema::dropIfExists('invoices');
    }
};
