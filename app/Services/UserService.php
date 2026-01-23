<?php

namespace App\Services;

use App\Dto\User\CreateUserDto;
use App\Dto\User\UpdateUserDto;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected function userAuth(): User
    {
        return auth()->user();
    }

    public function findAll()
    {
        return User::all();
    }

    public function find(User $user): User
    {

        return $user;
    }

    public function create(CreateUserDto $dto): User
    {
        $authUser = $this->userAuth();

        return DB::transaction(function () use ($dto, $authUser) {

            $user = User::create([
                ...$dto->toArray(),
                'tenant_id' => $authUser->type === 'TENANT'
                    ? $authUser->tenant_id
                    : null,

            ]);

            return $user->refresh();
        });
    }

    public function update(UpdateUserDTO $dto, User $user): User
    {
        return DB::transaction(function () use ($dto, $user) {

            $data = $dto->toArray();

            // 🔥 REGRA CRÍTICA: email é global
            if (isset($data['email']) && $data['email'] === $user->email) {
                unset($data['email']);
            }

            // 🔐 password opcional
            if (array_key_exists('password', $data) && empty($data['password'])) {
                unset($data['password']);
            }

            $user->update($data);

            return $user->refresh();
        });
    }

    public function delete(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->delete();
        });
    }
}
