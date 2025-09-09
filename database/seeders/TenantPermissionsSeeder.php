<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TenantPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = tenant('id'); // شغّله من سياق التينانت (tenancy:artisan أو داخل تينانت)

        app(PermissionRegistrar::class)->setPermissionsTeamId($tenantId);

        $perms = [
            'invoices.view',
            'invoices.create',
            'invoices.update',
            'invoices.delete',
            'invoice_items.view',
            'invoice_items.create',
            'invoice_items.update',
            'invoice_items.delete',
        ];

        foreach ($perms as $perm) {
            Permission::findOrCreate($perm, 'web'); // guard=web
        }

        // أمثلة أدوار (عدّل حسب أدوارك)
        $roles = [
            'Admin'   => $perms,
            'Accountant' => [
                'invoices.view','invoices.create','invoices.update',
                'invoice_items.view','invoice_items.create','invoice_items.update'
            ],
            'Viewer'  => ['invoices.view','invoice_items.view'],
        ];

        foreach ($roles as $roleName => $rolePerms) {
            $role = Role::findOrCreate($roleName, 'web');
            $role->syncPermissions($rolePerms);
        }
    }
}
