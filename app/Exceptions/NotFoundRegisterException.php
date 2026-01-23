<?php

namespace App\Exceptions;

use Exception;

class NotFoundRegisterException extends Exception
{
    protected int $status = Response::HTTP_NOT_FOUND;

    public function __construct(
        string $message = 'Register not found',
        int $status = Response::HTTP_NOT_FOUND
    ) {
        parent::__construct($message);
        $this->status = $status;
    }

    public function status(): int
    {
        return $this->status;
    }
}
