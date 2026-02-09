<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // DASHBOARD
        // =====================
        $dashboard = Menu::updateOrCreate(
            ['route' => 'dashboard'],
            [
                'name' => 'Dashboard',
                'icon' => 'mdi-view-dashboard',
                'order' => 1,
                'type' => 'BOTH',
                'permission_name' => 'view dashboard',
            ]
        );

        // =====================
        // CADASTROS (GRUPO)
        // =====================
        $cadastros = Menu::updateOrCreate(
            ['name' => 'Cadastros', 'parent_id' => null],
            [
                'icon' => 'mdi-database',
                'order' => 2,
                'type' => 'TENANT',
                'permission_name' => null,
            ]
        );

        $this->child($cadastros, 'Status', 'status.index', 'mdi-flag', 1, 'manage status');
        $this->child($cadastros, 'Categorias', 'categories.index', 'mdi-shape', 2, 'manage categories');
        $this->child($cadastros, 'Clientes', 'clients.index', 'mdi-account-group', 3, 'manage clients');
        $this->child($cadastros, 'Fornecedores', 'suppliers.index', 'mdi-truck', 4, 'manage suppliers');
        $this->child($cadastros, 'Produtos', 'products.index', 'mdi-package-variant', 5, 'manage products');
        $this->child($cadastros, 'Unidades', 'units.index', 'mdi-office-building', 6, 'manage units');
        $this->child($cadastros, 'Formas de Pagamento', 'payment-methods.index', 'mdi-credit-card', 7, 'manage payment methods');
        $this->child($cadastros, 'Condições de Pagamento', 'payment-terms.index', 'mdi-calendar-clock', 8, 'manage payment terms');

        // =====================
        // CONFIGURAÇÕES (GRUPO)
        // =====================
        $config = Menu::updateOrCreate(
            ['name' => 'Configurações', 'parent_id' => null],
            [
                'icon' => 'mdi-cog',
                'order' => 3,
                'type' => 'BOTH',
                'permission_name' => null,
            ]
        );

        $this->child($config, 'Empresas', 'tenants.index', 'mdi-domain', 1, 'manage tenants');
        $this->child($config, 'Usuários', 'users.index', 'mdi-account-multiple', 2, 'manage users');
        $this->child($config, 'Permissões', 'permissions.index', 'mdi-shield-key', 3, 'manage permissions');
        $this->child($config, 'Sistema', 'system.settings', 'mdi-cogs', 4, 'manage system');
    }

    private function child(
        Menu $parent,
        string $name,
        string $route,
        string $icon,
        int $order,
        ?string $permission
    ): void {
        Menu::updateOrCreate(
            [
                'route' => $route,
                'parent_id' => $parent->id,
            ],
            [
                'name' => $name,
                'icon' => $icon,
                'order' => $order,
                'type' => $parent->type,
                'permission_name' => $permission,
            ]
        );
    }
}
