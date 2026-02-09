<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\RolePermission\RolePermissionResource;
use App\Http\Resources\Tenant\TenantResource;
use App\Http\Resources\UserPreference\UserPreferenceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $this['user'];

        return [
            'token' => $this['token'],
            'user' => [
                'id' => $this['user']->id,
                'name' => $this['user']->name,
                'email' => $this['user']->email,

            ],
            'tenant' => TenantResource::collection($this['user']->tenants),
            'preferences' => UserPreferenceResource::collection($this['user']->preferences),
            // ✅ usa o resource dedicado
            'roles' => RolePermissionResource::collection(
                $user->roles
            ),
            'expires_in' => $this['expires_in'],
            'token_type' => $this['token_type'],
        ];
    }
}
