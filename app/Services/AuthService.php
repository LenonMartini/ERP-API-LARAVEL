<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $payload): array
    {
        $credentials = [
            'email' => $payload['email'],
            'password' => $payload['password'],
        ];

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        $user = Auth::user();

        // 🔥 Revoga tokens antigos (opcional, mas recomendado)
        $user->tokens()->delete();

        // ⏳ Tempo de expiração (ex: 7 dias)
        $expiresAt = Carbon::now()->addDays(7);

         // 🔐 Cria token
        $tokenResult = $user->createToken('auth_token');

        // 🔥 Define expiração
        $accessToken = $tokenResult->accessToken;
        $accessToken->expires_at = $expiresAt;
        $accessToken->save();

        return [
            'user' => $user,
            'token' => $tokenResult->plainTextToken, // ✅ SOMENTE ISSO
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt,
        ];
    }
    public function logout(): void
    {
        $user = auth()->user();
        if (!$user) {
           throw new \Exception("User not authenticated", 401);
        }
        $user->tokens()->delete();
        if ($user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }
    }
}
