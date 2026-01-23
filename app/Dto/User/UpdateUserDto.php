<?php

namespace App\DTO\User;

use Illuminate\Support\Facades\Hash;

class UpdateUserDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?int $status_id,
        public readonly ?string $password,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            status_id: $data['status_id'] ?? null,
            password: isset($data['password'])
                ? Hash::make($data['password'])
                : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'status_id' => $this->status_id,
            'password' => $this->password,
        ], fn ($value) => ! is_null($value));
    }
}
