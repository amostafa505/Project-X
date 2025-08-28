<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_notif_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->string('type')->nullable(); // class name / category
            $table->morphs('notifiable');       // notifiable_type, notifiable_id
            $table->text('data');               // JSON payload as text
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'notifiable_type', 'notifiable_id'], 'ix_notif_tenant_morph');
        });
    }
    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};
