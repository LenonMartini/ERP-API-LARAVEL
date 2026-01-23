<?php

namespace App\Http\Controllers\Api;

use App\Dto\User\CreateUserDto;
use App\Dto\User\UpdateUserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\ResponseUserResorce;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index()
    {
        $this->authorize('viewAny', User::class);
        $response = $this->userService->findAll();

        return ResponseUserResorce::collection($response);

    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        $response = $this->userService->find($user);

        return new ResponseUserResorce($response);

    }

    public function store(CreateUserRequest $request, User $user)
    {
        $this->authorize('create', User::class);
        $dto = CreateUserDto::fromArray($request->validated());
        $response = $this->userService->create($dto);

        return new ResponseUserResorce($response);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $dto = UpdateUserDto::fromArray($request->validated());
        $response = $this->userService->update($dto, $user);

        return new ResponseUserResorce($response);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $this->userService->delete($user);

        return response()->noContent();
    }
}
