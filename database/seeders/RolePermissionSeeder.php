<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔥 Limpa cache do Spatie
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissionsMap = [

            // 🌍 SYSTEM (só usuário SYSTEM vê isso)
            'system' => [
                'users' => ['view', 'create', 'update', 'delete'],
                'tenants' => ['view', 'create', 'update', 'delete'],
                'roles' => ['view', 'create', 'update', 'delete'],
            ],

            // 🏢 TENANT (usuários do tenant)
            'tenant' => [

                // 👤 Usuários do tenant
                'users' => ['view', 'create', 'update', 'delete'],

                // 📋 Cadastros
                'cadastros' => [
                    'produtos' => ['view', 'create', 'update', 'delete'],
                    'clientes' => ['view', 'create', 'update', 'delete'],
                    'fornecedores' => ['view', 'create', 'update', 'delete'],
                    'categorias' => ['view', 'create', 'update', 'delete'],
                ],

                // 🛒 Compras
                'compras' => [
                    'pedidos' => ['view', 'create', 'update', 'approve', 'cancel'],
                    'notas' => ['view', 'create', 'cancel'],
                ],

                // 💰 Vendas
                'vendas' => [
                    'pedidos' => ['view', 'create', 'update', 'cancel'],
                    'faturamento' => ['view', 'close'],
                ],

                // 🧾 PDV
                'pdv' => [
                    'caixa' => ['open', 'close', 'withdraw'],
                    'vendas' => ['create', 'cancel'],
                ],
            ],
        ];

        // 🔹 Criar permissões
        foreach ($permissionsMap as $scope => $modules) {
            foreach ($modules as $module => $resources) {

                // system.users.view
                if (is_array($resources) && isset($resources[0])) {
                    foreach ($resources as $action) {
                        Permission::firstOrCreate([
                            'name' => "{$scope}.{$module}.{$action}",
                            'guard_name' => 'web',
                        ]);
                    }

                    continue;
                }

                // tenant.cadastros.produtos.view
                foreach ($resources as $resource => $actions) {
                    foreach ($actions as $action) {
                        Permission::firstOrCreate([
                            'name' => "{$scope}.{$module}.{$resource}.{$action}",
                            'guard_name' => 'web',
                        ]);
                    }
                }
            }
        }

        // 🔹 Definição de ROLES (grupos de permissões)
        $roles = [

            // 👑 SYSTEM
            'super-admin' => ['system.*.*'],
            'admin-system' => ['system.*.*'],

            // 🏢 TENANT
            'admin-tenant' => ['tenant.*.*.*'],
            'manager' => [
                'tenant.cadastros.*.*',
                'tenant.compras.pedidos.view',
                'tenant.vendas.*.*',
                'tenant.pdv.caixa.open',
                'tenant.pdv.caixa.close',
            ],
            'operator' => [
                'tenant.pdv.caixa.open',
                'tenant.pdv.vendas.create',
                'tenant.pdv.vendas.cancel',
            ],
        ];

        foreach ($roles as $roleName => $patterns) {

            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $permissions = Permission::all()->filter(function ($permission) use ($patterns) {
                foreach ($patterns as $pattern) {
                    if (fnmatch($pattern, $permission->name)) {
                        return true;
                    }
                }

                return false;
            });

            $role->syncPermissions($permissions);
        }

    }
}
