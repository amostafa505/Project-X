<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('notifications_tenant');

        Schema::create('notifications_tenant', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_notifications_tenant')
                ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()->index()
                ->constrained('branches')->nullOnDelete();

            // Laravel-style
            $table->string('type');
            $table->morphs('notifiable'); // notifiable_type, notifiable_id
            $table->text('data');         // JSON text (as default Laravel)
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->index(['tenant_id', 'branch_id', 'notifiable_type', 'notifiable_id'], 'notifications_scope_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications_tenant');
    }
};
