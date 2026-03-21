<?php

namespace App\Http\Controllers\Api;

use App\Dto\Status\CreateStatusDto;
use App\Dto\Status\UpdateStatusDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Status\StatusRequest;
use App\Models\Status;
use App\Services\Status\StatusService;

class StatusController extends Controller
{
    public function __construct(
        private StatusService $statusService

    ) {}

    public function index()
    {
        $this->authorize('viewAny', Status::class);

        $response = $this->statusService->getAll();

        return response()->json($response);

    }

    public function show(Status $status)
    {

        $this->authorize('view', $status);

        $response = $this->statusService->getOne($status);

        return response()->json($response);
    }

    public function store(StatusRequest $request)
    {

        $this->authorize('create', Status::class);
        $input = $request->validated();
        $dto = new CreateStatusDto(
            name: $input['name']
        );
        $response = $this->statusService->create($dto);

        return response()->json($response);
    }
    public function update(StatusRequest $request, Status $status)
    {
        $this->authorize('update', $status);
        $input = $request->validated();
        $dto = new UpdateStatusDto(
            name: $input['name']
        );
        $response = $this->statusService->update($status, $dto);

        return response()->json($response);
    }
    public function destroy(Status $status){
        $this->authorize('delete', $status);

        $this->statusService->delete($status);

        return response()->noContent(); // 204
    }
}
