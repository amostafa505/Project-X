<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // لازم جدول organizations يكون موجود قبل إضافة الـ FK
        if (!Schema::hasTable('organizations')) {
            // تقدر بدل return ترمي Exception لو عايز تجبر ترتيب الملفات
            return;
        }

        // أضف عمود organization_id لو مش موجود
        Schema::table('tenants', function (Blueprint $table) {
            if (!Schema::hasColumn('tenants', 'organization_id')) {
                $table->unsignedBigInteger('organization_id')
                    ->nullable()
                    ->index()
                    ->after('type');
            }
        });

        // جرّب تسقط أي FK قديم مرتبط بالعمود (الاسم الافتراضي)
        try {
            Schema::table('tenants', function (Blueprint $table) {
                $table->dropForeign(['organization_id']); // tenants_organization_id_foreign
            });
        } catch (\Throwable $e) {
            // تجاهل لو مفيش FK بالاسم ده
        }

        // جرّب تسقط أي FK باسم مخصّص قديم (لو كنت مستخدم fk_tenants_org قبل كده)
        try {
            // مفيش طريقة بإسم مخصّص غير SQL، بس هنسيبه مع تعليق
            // لو لسه عندك قيد باسم fk_tenants_org ومش راضي يتشال، نفّذ ده يدويًا في MySQL:
            // ALTER TABLE `tenants` DROP FOREIGN KEY `fk_tenants_org`;
        } catch (\Throwable $e) {
            //
        }

        // أضف الـ FK بالاسم الافتراضي
        Schema::table('tenants', function (Blueprint $table) {
            $table->foreign('organization_id')
                ->references('id')->on('organizations')
                ->nullOnDelete(); // ON DELETE SET NULL
        });
    }

    public function down(): void
    {
        // اسقط الـ FK الافتراضي
        try {
            Schema::table('tenants', function (Blueprint $table) {
                $table->dropForeign(['organization_id']);
            });
        } catch (\Throwable $e) {
            //
        }

        // (اختياري) شيل العمود
        // Schema::table('tenants', function (Blueprint $table) {
        //     if (Schema::hasColumn('tenants', 'organization_id')) {
        //         $table->dropColumn('organization_id');
        //     }
        // });
    }
};
