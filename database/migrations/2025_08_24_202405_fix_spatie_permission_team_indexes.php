<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) roles.tenant_id = UUID NOT NULL + unique داخل التينانت
        if (Schema::hasColumn('roles', 'tenant_id')) {
            // تأكد من النوع و NOT NULL (يتطلب doctrine/dbal)
            Schema::table('roles', function (Blueprint $table) {
                $table->uuid('tenant_id')->change();
            });

            // احذف الـ unique القديم لو موجود باسم مختلف ثم أضف واحد موحّد
            $this->dropIndexIfExists('roles', 'uq_roles_tenant_name_guard');
            $this->dropIndexIfExists('roles', 'roles_tenant_id_name_guard_name_unique'); // أسماء Laravel الافتراضية المحتملة

            // أضف الـ UNIQUE لو مش موجود
            if (! $this->indexExists('roles', 'uq_roles_tenant_name_guard')) {
                Schema::table('roles', function (Blueprint $table) {
                    $table->unique(['tenant_id', 'name', 'guard_name'], 'uq_roles_tenant_name_guard');
                });
            }
        }

        // 2) model_has_roles: tenant_id = UUID NOT NULL + PK مركّب
        if (! Schema::hasColumn('model_has_roles', 'tenant_id')) {
            Schema::table('model_has_roles', function (Blueprint $table) {
                $table->uuid('tenant_id')->after('role_id');
            });
        } else {
            Schema::table('model_has_roles', function (Blueprint $table) {
                $table->uuid('tenant_id')->change();
            });
        }

        // أعد بناء الـ PRIMARY KEY بشكل آمن
        $this->dropPrimaryIfExists('model_has_roles');
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->primary(['role_id','model_id','model_type','tenant_id'], 'pk_model_has_roles');
        });

        // 3) model_has_permissions: tenant_id = UUID NOT NULL + PK مركّب
        if (! Schema::hasColumn('model_has_permissions', 'tenant_id')) {
            Schema::table('model_has_permissions', function (Blueprint $table) {
                $table->uuid('tenant_id')->after('permission_id');
            });
        } else {
            Schema::table('model_has_permissions', function (Blueprint $table) {
                $table->uuid('tenant_id')->change();
            });
        }

        $this->dropPrimaryIfExists('model_has_permissions');
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->primary(['permission_id','model_id','model_type','tenant_id'], 'pk_model_has_permissions');
        });

        // ملاحظة: permissions و role_has_permissions لا يحتاجوا tenant_id.
    }

    public function down(): void
    {
        // رجّع الـ PKs القديمة (بدون tenant_id) فقط لو احتجت
        $this->dropPrimaryIfExists('model_has_roles');
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->primary(['role_id','model_id','model_type']);
        });

        $this->dropPrimaryIfExists('model_has_permissions');
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->primary(['permission_id','model_id','model_type']);
        });

        // (لن نغيّر نوع الأعمدة رجوعًا لتجنب فقدان بيانات)
        $this->dropIndexIfExists('roles', 'uq_roles_tenant_name_guard');
    }

    /** Helpers **/

    private function indexExists(string $table, string $indexName): bool
    {
        $db = DB::getDatabaseName();
        $sql = "SELECT COUNT(1) AS c
                FROM information_schema.statistics
                WHERE table_schema = ? AND table_name = ? AND index_name = ?";
        $res = DB::select($sql, [$db, $table, $indexName]);
        return isset($res[0]) && (int)$res[0]->c > 0;
    }

    private function dropIndexIfExists(string $table, string $indexName): void
    {
        if ($this->indexExists($table, $indexName)) {
            DB::statement("DROP INDEX `$indexName` ON `$table`");
        }
    }

    private function dropPrimaryIfExists(string $table): void
    {
        // افحص إن كان فيه PRIMARY KEY
        $db = DB::getDatabaseName();
        $sql = "SELECT COUNT(1) AS c
                FROM information_schema.table_constraints
                WHERE table_schema = ? AND table_name = ? AND constraint_type = 'PRIMARY KEY'";
        $res = DB::select($sql, [$db, $table]);
        if (isset($res[0]) && (int)$res[0]->c > 0) {
            DB::statement("ALTER TABLE `$table` DROP PRIMARY KEY");
        }
    }
};
