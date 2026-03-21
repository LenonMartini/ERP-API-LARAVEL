<?php

namespace App\Dto\Status;

class UpdateStatusDto
{
    public function __construct(
        public readonly string $name,
    ) {}

    private static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => strtoupper($this->name),
        ];
    }
}
