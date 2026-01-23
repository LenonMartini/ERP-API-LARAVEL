<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class TenantService
{
    public function getAll()
    {
        $response = Tenant::all();

        return $response;
    }

    public function get(Tenant $tenant): Tenant
    {
        return $tenant;
    }

    /**
     * Create a new tenant
     *
     * @param  array  $data  The tenant data
     * @return Tenant The created tenant
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $tenant = Tenant::create($data);
            $tenant->refresh();

            return $tenant;
        });
    }

    public function update(Tenant $tenant, array $data): Tenant
    {
        return DB::transaction(function () use ($tenant, $data) {
            $tenant->update($data);

            // recarrega defaults / relations se necessário
            return $tenant->refresh();
        });
    }

    public function delete(Tenant $tenant): void
    {
        DB::transaction(function () use ($tenant) {
            $tenant->delete();
        });
    }
}
