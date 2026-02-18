<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $payload)
    {
        $credentials = [
            'email' => $payload['email'],
            'password' => $payload['password'],
        ];

        if (! $token = auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }
        if (! auth()->user()) {
            throw \Exception('User not authenticated', 401);
        }
        $user = User::with('tenants')->with('preferences')->find(auth()->user()->id);

        if (! $user) {
            throw \Exception('User not found', 404);
        }

        // Recuperar grupos e permissões de usuario
        return [
            'user' => $user,
            'token' => $token,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->availablePermissions()->pluck('name'),
            'preferences' => $user->preferences,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60, // segundos
        ];
    }

    public function logout(): array
    {
        if (! auth()->check()) {
            return [
                'message' => 'Unauthenticated user.',
            ];
        }

        auth()->logout();

        return [
            'message' => 'Successfully logged out.',
        ];
    }

    public function getUserAuth()
    {
        return auth()->user();
    }
}
