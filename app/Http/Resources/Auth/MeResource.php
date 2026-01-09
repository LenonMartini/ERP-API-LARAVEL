<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['user']->id,
            'name' => $this['user']->name,
            'email' => $this['user']->email,
            'token' => $this['token'],
            'expires_in' => $this['expires_in'],
            'token_type' => $this['token_type'],
        ];
    }
}
