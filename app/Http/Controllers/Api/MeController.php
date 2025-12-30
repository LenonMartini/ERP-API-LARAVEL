<?php

namespace App\Http\Controllers\Api;

use App\Services\MeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\MeResource;

class MeController extends Controller
{
    public function __construct(private MeService $meService) {}
    public function me()
    {
        $response = $this->meService->me();

        return new MeResource($response);
    }
    public function rolesPermissions()
    {
        $response = $this->meService->rolesPermissions();

        return response()->json($response);
    }
}
