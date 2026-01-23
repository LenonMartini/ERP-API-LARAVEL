<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\TenantRequest;
use App\Http\Resources\Tenant\TenantResource;
use App\Models\Tenant;
use App\Services\TenantService;

class TenantController extends Controller
{
    public function __construct(private TenantService $tenantService) {}

    public function index()
    {
        $this->authorize('viewAny', Tenant::class);
        $response = $this->tenantService->getAll();

        return TenantResource::collection($response);
    }

    public function show(Tenant $tenant)
    {
        $this->authorize('view', $tenant);
        $response = $this->tenantService->get($tenant);

        return new TenantResource($response);
    }

    public function store(TenantRequest $request)
    {
        $this->authorize('create', Tenant::class);
        $response = $this->tenantService->create($request->validated());

        return new TenantResource($response);
    }

    public function update(TenantRequest $request, Tenant $tenant)
    {
        $this->authorize('update', $tenant);

        $response = $this->tenantService->update($tenant, $request->validated());

        return new TenantResource($response);
    }

    public function destroy(Tenant $tenant)
    {
        $this->authorize('delete', $tenant);

        $this->tenantService->delete($tenant);

        return response()->noContent(); // 204
    }
}
