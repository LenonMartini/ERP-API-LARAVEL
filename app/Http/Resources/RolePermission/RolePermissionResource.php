<?php

namespace App\Http\Resources\RolePermission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RolePermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth()->user();

        return [
            'id' => $this->id,
            'name' => $this->name,

            'permissions' => $this->permissions
                ->filter(function ($permission) use ($user) {

                    // SYSTEM vê system.*
                    if ($user->type === 'SYSTEM') {
                        return str_starts_with($permission->name, 'system.');
                    }

                    // TENANT vê tenant.*
                    return str_starts_with($permission->name, 'tenant.');
                })
                ->map(fn ($permission) => [
                    'id' => $permission->id,
                    'name' => $permission->name,
                ])
                ->values(),
        ];
    }
}
