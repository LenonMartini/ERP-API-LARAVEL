<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class MeService
{
    public function me(Request $request): array
    {
        if (! auth()->check()) {
            throw new AuthenticationException('Unauthenticated user.');
        }

        $userAuth = auth()->user();

        $user = User::with('preferences')->find($userAuth->id);

        return [
            'user' => $user,
            'token' => $request->bearerToken(),
            'roles' => $user->getRoleNames(),
            'permissions' => $user->availablePermissions()->pluck('name'),
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60, // segundos
        ];
    }

    public function rolesPermissions()
    {
        $auth = auth()->user();
        if (! $auth) {
            throw new \Exception('User not authenticated', 401);
        }

        return [
            'roles' => $auth->getRoleNames(),
            'permissions' => auth()->user()->permissionsTree(),
        ];
    }
}
