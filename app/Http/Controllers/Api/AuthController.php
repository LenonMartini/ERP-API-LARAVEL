<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function login(AuthRequest $request)
    {

        $response = $this->authService->login($request->validated());

        /*return response()->json(
            $response
        );*/
        // return $response;
        return new AuthResource($response);
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
