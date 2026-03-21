<?php

namespace App\Services\Status;

use App\Dto\Status\CreateStatusDto;
use App\Dto\Status\UpdateStatusDto;
use App\Http\Resources\Status\StatusResource;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use App\Services\Auth\AuthService;

class StatusService
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function getAll()
    {
        $response = Status::where('tenant_id', $this->authService->getUserAuth()['tenant']['id'])
                            ->orderBy('id','DESC')
                            ->get();

        return StatusResource::collection($response);
    }

    public function getOne(Status $status)
    {

        $response = Status::where('tenant_id', $this->authService->getUserAuth()['tenant']['id'])
            ->where('id', $status->id)
            ->first();

        return new StatusResource($response);
    }

    public function create(CreateStatusDto $dto): Status
    {
        return DB::transaction(function () use ($dto) {
            $tenantId = $this->authService->getUserAuth()['tenant']['id'];
            return Status::create([
                'tenant_id' => $tenantId,
                'name' => strtoupper($dto->name),
            ]);
        });
    }

    public function update(Status $status, UpdateStatusDto $dto): Status
    {

        return DB::transaction(function () use ($status, $dto) {

            $status->update($dto->toArray());

            return $status;
        });
    }

    public function delete(Status $status): void {
        DB::transaction(function () use ($status) {
            $status->delete();
        });
    }
}
