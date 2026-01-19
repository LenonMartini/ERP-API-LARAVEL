<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class MeService
{
    public function me(): array
    {
        if (! auth()->check()) {
            throw new AuthenticationException('Unauthenticated user.');
        }

        $userAuth = auth()->user();

        $user = User::with('preferences')->find($userAuth->id);

        // Pega o token atual do header Authorization
        $token = JWTAuth::getToken();

        return [
            'user' => $user,
            'token' => (string) $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
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
