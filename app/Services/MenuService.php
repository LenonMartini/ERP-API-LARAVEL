<?php

namespace App\Services;

use App\Models\Menu;

class MenuService
{
    public function __construct(private AuthService $authService) {}

    public function findAll()
    {
        $user = $this->authService->getUserAuth();

        $types = $user->type === 'SYSTEM'
            ? ['SYSTEM', 'BOTH']
            : ['TENANT', 'BOTH'];

        $menus = Menu::where('status', 'ACTIVE')
            ->whereIn('type', $types)
            ->orderBy('order')
            ->get()
            ->filter(function ($menu) use ($user) {

                // menu sem permissão → visível
                if (! $menu->permission_name) {
                    return true;
                }

                return $user->can($menu->permission_name);
            })
            ->values();

        return $this->buildTree($menus);
    }

    private function buildTree($menus)
    {
        $grouped = $menus->groupBy(fn ($m) => $m->parent_id ?? 0);

        return $this->formatTree($grouped, 0);
    }

    private function formatTree($grouped, $parentId)
    {
        return collect($grouped[$parentId] ?? [])
            ->sortBy('order')
            ->map(function ($menu) use ($grouped) {

                $children = $this->formatTree($grouped, $menu->id);

                if ($menu->permission_name) {
                    if (! $this->authService->getUserAuth()->can($menu->permission_name)) {
                        return null;
                    }
                }

                if (! $menu->permission_name && $children->isEmpty() && ! $menu->url) {
                    return null;
                }

                return [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'url' => $menu->url,
                    'icon' => $menu->icon,
                    'children' => $children,
                ];
            })
            ->filter()
            ->values();
    }
}
