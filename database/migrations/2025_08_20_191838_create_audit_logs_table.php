<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('audit_logs');

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_audit_logs_tenant')
                ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()->index()
                ->constrained('branches')->nullOnDelete();

            // who did it?
            $table->nullableMorphs('causer');  // causer_type, causer_id (e.g., User)
            // what was affected?
            $table->nullableMorphs('subject'); // subject_type, subject_id (e.g., Invoice)

            $table->string('event')->index();  // created|updated|deleted|login|logout|custom
            $table->json('properties')->nullable(); // before/after or any payload

            $table->string('ip_address', 45)->nullable(); // IPv4/IPv6
            $table->string('user_agent')->nullable();

            $table->timestamps();

            $table->index(['tenant_id', 'branch_id', 'event'], 'audit_logs_scope_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
