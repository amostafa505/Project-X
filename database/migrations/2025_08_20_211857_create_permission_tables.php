<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fresh install tailored for multi-tenant (UUID tenant_id).
     * - roles: add tenant_id (uuid, not null) + unique per tenant (tenant_id, name, guard_name)
     * - model_has_roles & model_has_permissions: add tenant_id (uuid, not null) into composite PK
     * - permissions & role_has_permissions remain global (no tenant_id)
     */
    public function up(): void
    {
        $tableNames  = config('permission.table_names');
        $columnNames = config('permission.column_names');

        // permissions
        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            $table->unique(['name', 'guard_name'], 'uq_permissions_name_guard');
        });

        // roles (scoped by tenant)
        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            // IMPORTANT: we hardcode uuid here; do NOT rely on spatie default unsignedBigInteger
            $table->uuid('tenant_id'); // NOT NULL by default in Laravel 10+, else add ->nullable(false)
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            // unique role name per tenant & guard
            $table->unique(['tenant_id', 'name', 'guard_name'], 'uq_roles_tenant_name_guard');

            // Optional, but handy for queries
            $table->index(['tenant_id'], 'idx_roles_tenant_id');
        });

        // role_has_permissions (global: no tenant_id)
        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'pk_role_has_permissions');
        });

        // model_has_permissions (scoped by tenant)
        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');

            // spatie default morphs: model_type + model_id
            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);

            // IMPORTANT: tenant scope
            $table->uuid('tenant_id');

            $table->index([$columnNames['model_morph_key'], 'model_type'], 'idx_mhp_model');
            $table->index(['tenant_id'], 'idx_mhp_tenant');

            $table->foreign('permission_id')
                ->references('id')->on($tableNames['permissions'])
                ->onDelete('cascade');

            // Composite PK including tenant_id
            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type', 'tenant_id'], 'pk_model_has_permissions');
        });

        // model_has_roles (scoped by tenant)
        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');

            // spatie default morphs: model_type + model_id
            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);

            // IMPORTANT: tenant scope
            $table->uuid('tenant_id');

            $table->index([$columnNames['model_morph_key'], 'model_type'], 'idx_mhr_model');
            $table->index(['tenant_id'], 'idx_mhr_tenant');

            $table->foreign('role_id')
                ->references('id')->on($tableNames['roles'])
                ->onDelete('cascade');

            // Composite PK including tenant_id
            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type', 'tenant_id'], 'pk_model_has_roles');
        });

        // Cache cleanup key (same as spatie)
        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    public function down(): void
    {
        $tableNames = config('permission.table_names');

        // Drop in reverse order
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
    }
};
