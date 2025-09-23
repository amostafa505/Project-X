<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class TenantPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = tenant('id');
        app(PermissionRegistrar::class)->setPermissionsTeamId($tenantId);

        $perms = [
            'students.view', 'students.create', 'students.update',
            'teachers.view', 'teachers.create', 'teachers.update',
            'classrooms.view', 'classrooms.create', 'classrooms.update',
            'subjects.view', 'subjects.create', 'subjects.update',
            'enrollments.view', 'enrollments.create', 'enrollments.update',
            'invoices.view', 'invoices.create', 'invoices.update',
            'invoice_items.view', 'invoice_items.create', 'invoice_items.update',
            'payments.view', 'payments.create',
            'branches.view', 'branches.create', 'branches.update',
            'branches.viewAll', // مهم لو هتدي لمدير يشوف كل الفروع
        ];

        foreach ($perms as $p) {
            Permission::findOrCreate($p, 'web');
        }

        $roles = [
            'Admin'      => $perms,
            'Accountant' => ['invoices.*', 'invoice_items.*', 'payments.*'],
            'Viewer'     => ['students.view', 'teachers.view', 'classrooms.view', 'subjects.view', 'invoices.view'],
        ];

        foreach ($roles as $roleName => $rolePerms) {
            $role = Role::findOrCreate($roleName, 'web');
            $role->syncPermissions($rolePerms);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
