<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'domain' => $this->domain,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'), //$this->created_at,
            'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y'), //$this->updated_at,
        ];
    }
}
