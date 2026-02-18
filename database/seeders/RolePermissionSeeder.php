<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [

            // ===== SYSTEM =====
            'system.tenants.view',
            'system.tenants.create',
            'system.tenants.update',
            'system.tenants.delete',

            'system.settings.view',

            // ===== TENANT =====
            'tenant.users.view',
            'tenant.users.create',
            'tenant.users.update',
            'tenant.users.delete',

            'tenant.cadastros.status.view',
            'tenant.cadastros.categorias.view',
            'tenant.cadastros.clientes.view',
            'tenant.cadastros.fornecedores.view',
            'tenant.cadastros.produtos.view',
            'tenant.cadastros.unidades.view',

            'tenant.roles.view',
            'tenant.roles.create',
            'tenant.roles.update',
            'tenant.roles.delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'web',
            ]);
        }

        // 🔵 SYSTEM ROLE
        $system = Role::firstOrCreate(['name' => 'admin-system', 'guard_name' => 'web']);
        $system->syncPermissions(
            Permission::where('name', 'like', 'system.%')->get()
        );

        // 🟢 TENANT ROLE
        $tenant = Role::firstOrCreate(['name' => 'admin-tenant', 'guard_name' => 'web']);
        $tenant->syncPermissions(
            Permission::where('name', 'like', 'tenant.%')->get()
        );

        // 👑 SUPER ROOT (opcional)
        $root = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $root->syncPermissions(Permission::all());
    }
}
