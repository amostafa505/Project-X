<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_audit_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->morphs('auditable'); // auditable_type, _id
            $table->foreignId('causer_id')->nullable()->constrained('tenant_users')->nullOnDelete();
            $table->string('event');          // created/updated/deleted/assigned...
            $table->json('properties')->nullable(); // before/after or extra
            $table->timestamp('created_at')->useCurrent();

            $table->index(['tenant_id', 'event'], 'ix_audit_tenant_event');
        });
    }
    public function down(): void {
        Schema::dropIfExists('audit_logs');
    }
};
