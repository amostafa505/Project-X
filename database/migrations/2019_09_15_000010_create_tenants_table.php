<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create tenants (UUID PK) + (optional) tenant_domains.
     */
    public function up(): void
    {
        // ---------- TENANTS ----------
        Schema::create('tenants', function (Blueprint $table) {
            // UUID primary key (Stancl Tenancy-friendly)
            $table->uuid('id')->primary();

            // Basic identity
            $table->string('code')->unique();           // مختصر فريد: ex. ANDA-SCH-001
            $table->string('name');                     // الاسم التجاري/الوصف

            $table->string('default_locale')->default('en');

            // Multi-vertical support
            $table->string('type')->default('school');  // school | clinic | pharmacy | ...

            // Optional higher-level grouping
            $table->unsignedBigInteger('organization_id')->nullable()->index();

            // Ownership (اختياري)
            $table->unsignedBigInteger('owner_user_id')->nullable()->index();

            // Commercial / locale
            $table->string('plan')->default('free');    // free | pro | enterprise | ...
            $table->string('currency', 3)->default('EGP');
            $table->string('locale', 10)->default('ar');      // ar | en | fr ...
            $table->string('timezone', 64)->default('Africa/Cairo');

            // Lifecycle
            $table->enum('status', ['active', 'trial', 'suspended', 'cancelled'])
                ->default('active')->index();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('billing_starts_at')->nullable();

            // Flexible config
            $table->json('data')->nullable(); // feature flags, modules, branding, integrations...
            $table->json('meta')->nullable(); // أي معلومات إضافية للتقارير

            // Audit
            $table->timestamps();
            // Soft deletes (اختياري). فعّلها لو تحب تسترجع Tenants لاحقًا.
            $table->softDeletes();

            // FKs (اختيارية) — علّقها لو ماعندك الجداول/المفاتيح
            // $table->foreign('organization_id', 'fk_tenants_org')
            //     ->references('id')->on('organizations')->nullOnDelete();
            $table->foreign('owner_user_id', 'fk_tenants_owner_user')
                ->references('id')->on('users')->nullOnDelete();
        });

        // ---------- TENANT DOMAINS (اختياري) ----------
        // لو محتاج تربط أكتر من دومين لكل تينانت (Stancl يدعم تعدد الدومينات)
        // Schema::create('tenant_domains', function (Blueprint $table) {
        //     $table->id();
        //     $table->uuid('tenant_id')->index();
        //     $table->string('domain')->unique(); // ex. school1.example.com
        //     $table->boolean('is_primary')->default(false)->index();
        //     $table->timestamps();

        //     $table->foreign('tenant_id', 'fk_tenant_domains_tenant')
        //         ->references('id')->on('tenants')->cascadeOnDelete();
        // });

        // اندكسات عملية إضافية
        Schema::table('tenants', function (Blueprint $table) {
            $table->index(['type', 'status'], 'tenants_type_status_idx');
        });
    }

    public function down(): void
    {
        // اسحب الدومينات الأول علشان FK
        if (Schema::hasTable('tenant_domains')) {
            Schema::table('tenant_domains', function (Blueprint $table) {
                $table->dropForeign('fk_tenant_domains_tenant');
            });
            Schema::dropIfExists('tenant_domains');
        }

        // بعدها اسحب tenants
        // لو فعّلت FKs فوق (organizations/users) لازم تشيلها هنا قبل dropColumn
        if (Schema::hasTable('tenants')) {
            // Example (لو كنت فعّلتهم):
            Schema::table('tenants', function (Blueprint $table) {
                // $table->dropForeign('fk_tenants_org');
                //     $table->dropForeign('fk_tenants_owner_user');
            });

            Schema::dropIfExists('tenants');
        }
    }
};
