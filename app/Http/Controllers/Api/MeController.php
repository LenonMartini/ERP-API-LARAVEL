<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Me\MeRequest;
use App\Http\Resources\Auth\MeResource;
use App\Services\MeService;

class MeController extends Controller
{
    public function __construct(private MeService $meService) {}

    public function me(MeRequest $request)
    {

        $response = $this->meService->me($request);

        return new MeResource($response);
    }

    public function rolesPermissions()
    {
        $response = $this->meService->rolesPermissions();

        return response()->json($response);
    }
}
