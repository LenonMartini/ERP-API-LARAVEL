<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\UserPreference\UserPreferenceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this['user']->id,
                'name' => $this['user']->name,
                'email' => $this['user']->email,

            ],
            'preferences' => UserPreferenceResource::collection($this['user']->preferences),
            'token' => $this['token'],
            'expires_in' => $this['expires_in'],
            'token_type' => $this['token_type'],
        ];
    }
}
