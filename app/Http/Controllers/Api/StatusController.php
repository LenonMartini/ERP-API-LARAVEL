<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Status\StatusRequest;
use App\Models\Status;
use App\Services\StatusService;

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
        $response = $this->statusService->create($request->validated());

        return response()->json($response);
    }
}
