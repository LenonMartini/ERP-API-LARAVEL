<?php

namespace App\Services;

use App\Dto\Status\CreateStatusDto;
use App\Http\Resources\Status\StatusResource;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class StatusService
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function getAll()
    {
        $response = Status::where('tenant_id', $this->authService->getUserAuth()['tenant']['id'])->get();

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
        return $this->authService->getUserAuth()['tenant']['id'];
        // return DB::transaction(function () use (){});
    }

    public function update() {}

    public function delete() {}
}
