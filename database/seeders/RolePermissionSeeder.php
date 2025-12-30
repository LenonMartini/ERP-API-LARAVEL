<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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

            // ⚙️ CONFIGURAÇÕES DO SISTEMA
            'configuracoes' => [
                'usuarios' => ['visualizar', 'criar', 'atualizar', 'excluir'],
                'tenants' => ['visualizar', 'criar', 'atualizar', 'excluir'],
                'perfis' => ['visualizar', 'criar', 'atualizar', 'excluir'], // roles
            ],

            // 📋 CADASTROS GERAIS
            'cadastros' => [
                'produtos' => ['visualizar', 'criar', 'atualizar', 'excluir'],
                'clientes' => ['visualizar', 'criar', 'atualizar', 'excluir'],
                'fornecedores' => ['visualizar', 'criar', 'atualizar', 'excluir'],
                'categorias' => ['visualizar', 'criar', 'atualizar', 'excluir'],
            ],

            // 🛒 COMPRAS
            'compras' => [
                'pedidos' => ['visualizar', 'criar', 'atualizar', 'aprovar', 'cancelar'],
                'notas' => ['visualizar', 'criar', 'cancelar'],
            ],

            // 💰 VENDAS
            'vendas' => [
                'pedidos' => ['visualizar', 'criar', 'atualizar', 'cancelar'],
                'faturamento' => ['visualizar', 'fechar'],
            ],

            // 🧾 PDV
            'pdv' => [
                'caixa' => ['abrir', 'fechar', 'sangria'],
                'vendas' => ['criar', 'cancelar'],
            ],
        ];


        // 🔹 Criar permissões
        foreach ($permissionsMap as $category => $modules) {
            foreach ($modules as $module => $actions) {
                foreach ($actions as $action) {
                    Permission::firstOrCreate([
                        'name' => "{$category}.{$module}.{$action}",
                        'guard_name' => 'web',
                    ]);
                }
            }
        }

        // 🔹 Definição de ROLES (grupos de permissões)
        $roles = [

            // 👑 SUPER ADMIN (tudo)
            'super-admin' => Permission::all(),

            // ⚙️ ADMINISTRADOR
            'admin' => [
                'config.users.*',
                'config.roles.*',
                'cadastros.*.*',
                'compras.*.*',
                'vendas.*.*',
                'pdv.*.*',
            ],

            // 📊 GERENTE
            'manager' => [
                'cadastros.*.*',
                'compras.pedidos.view',
                'compras.pedidos.approve',
                'vendas.*.*',
                'pdv.caixa.open',
                'pdv.caixa.close',
            ],

            // 🧑 OPERADOR / PDV
            'operator' => [
                'pdv.caixa.open',
                'pdv.vendas.create',
                'pdv.vendas.cancel',
            ],
        ];

        foreach ($roles as $roleName => $permissionPatterns) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            // Resolve curingas (*. *)
            $resolvedPermissions = Permission::all()->filter(function ($permission) use ($permissionPatterns) {
                foreach ($permissionPatterns as $pattern) {
                    if (fnmatch($pattern, $permission->name)) {
                        return true;
                    }
                }
                return false;
            });

            $role->syncPermissions($resolvedPermissions);
        }
    }
}
