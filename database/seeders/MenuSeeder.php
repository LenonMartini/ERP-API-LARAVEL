<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // ================= DASHBOARD
        Menu::updateOrCreate(
            ['url' => '/painel'],
            [
                'name' => 'Dashboard',
                'icon' => 'mdi-view-dashboard',
                'order' => 1,
                'type' => 'BOTH',
                'permission_name' => null,
            ]
        );

        // ================= CADASTROS (TENANT)
        $cadastros = Menu::updateOrCreate(
            ['name' => 'Cadastros', 'parent_id' => null],
            [
                'icon' => 'mdi-database',
                'order' => 2,
                'type' => 'TENANT',
                'permission_name' => null,
            ]
        );

        $this->child($cadastros, 'Status', '/cadastros/status', 'mdi-flag', 1, 'tenant.cadastros.status.view', 'TENANT');
        $this->child($cadastros, 'Categorias', '/cadastros/categorias', 'mdi-shape', 2, 'tenant.cadastros.categorias.view', 'TENANT');
        $this->child($cadastros, 'Clientes', '/cadastros/clientes', 'mdi-account-group', 3, 'tenant.cadastros.clientes.view', 'TENANT');
        $this->child($cadastros, 'Fornecedores', '/cadastros/fornecedores', 'mdi-truck', 4, 'tenant.cadastros.fornecedores.view', 'TENANT');
        $this->child($cadastros, 'Produtos', '/cadastros/produtos', 'mdi-package-variant', 5, 'tenant.cadastros.produtos.view', 'TENANT');
        $this->child($cadastros, 'Unidades', '/cadastros/unidades', 'mdi-office-building', 6, 'tenant.cadastros.unidades.view', 'TENANT');

        // ================= CONFIG
        $config = Menu::updateOrCreate(
            ['name' => 'Configurações', 'parent_id' => null],
            [
                'icon' => 'mdi-cog',
                'order' => 3,
                'type' => 'BOTH',
                'permission_name' => null,
            ]
        );

        // 🔵 SYSTEM
        $this->child($config, 'Empresas', '/config/empresas', 'mdi-domain', 1, 'system.tenants.view', 'SYSTEM');
        $this->child($config, 'Sistema', '/config/sistema', 'mdi-cogs', 3, 'system.settings.view', 'SYSTEM');

        // 🟢 TENANT
        $this->child($config, 'Usuários', '/config/usuarios', 'mdi-account-multiple', 4, 'tenant.users.view', 'TENANT');
        $this->child($config, 'Permissões', '/config/permissoes', 'mdi-shield-key', 2, 'tenant.roles.view', 'TENANT');
    }

    private function child(
        Menu $parent,
        string $name,
        string $url,
        string $icon,
        int $order,
        ?string $permission,
        string $type
    ): void {
        Menu::updateOrCreate(
            [
                'url' => $url,
                'parent_id' => $parent->id,
            ],
            [
                'name' => $name,
                'icon' => $icon,
                'order' => $order,
                'type' => $type,
                'permission_name' => $permission,
            ]
        );
    }
}
