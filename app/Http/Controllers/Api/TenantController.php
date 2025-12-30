<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\TenantService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\TenantRequest;
use App\Http\Resources\Tenant\TenantResource;

class TenantController extends Controller
{
    public function __construct(private TenantService $tenantService){ }

    public function index()
    {
        $response = $this->tenantService->getAll();
        return TenantResource::collection($response);
    }
    public function show(int $id)
    {
        $response = $this->tenantService->getById($id);
        return new TenantResource($response);
    }
    public function store(TenantRequest $request)
    {

        $response = $this->tenantService->create($request->validated());
        return new TenantResource($response);
    }
    public function update(TenantRequest $request, int $id)
    {
        $response = $this->tenantService->update($id, $request->validated());
        return new TenantResource($response);
    }
    public function destroy(int $id)
    {
        $response = $this->tenantService->delete($id);
        if(!$response){
            return response()->json(['message' => 'Error deleting tenant'], 404);
        }
        return response()->json(['message' => 'Tenant deleted successfully']);
    }

}
