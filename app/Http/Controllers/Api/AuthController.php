<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Resources\Auth\AuthResource;

class AuthController extends Controller
{
   public function __construct(private AuthService $authService){ }

    public function login(AuthRequest $request)
    {

            $response = $this->authService->login($request->validated());
            return response()->json(
                new AuthResource($response),
                200
            );
    }
    public function logout()
    {
            $this->authService->logout();
            return response()->json(
                ['message' => 'Logged out successfully'],
                200
            );
    }
}
