<?php

namespace App\Services;

use Exception;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function login(array $payload): array
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

        return [
            'user' => auth()->user(),
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60, // segundos
        ];
    }

   public function logout(): array
    {
        if (! auth()->check()) {
            return [
                'message' => 'Unauthenticated user.'
            ];
        }

        auth()->logout();

        return [
            'message' => 'Successfully logged out.'
        ];
    }


 
}
