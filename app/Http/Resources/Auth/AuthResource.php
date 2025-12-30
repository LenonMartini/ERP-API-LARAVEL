<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['user']->id,
            'name' => $this['user']->name,
            'email' => $this['user']->email,
            'token' => $this['token'],
            'expires_at' => $this['expires_at'],
            'token_type' => $this['token_type'],
        ];
    }
}
