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
    public function getById(int $id)
    {
        $response = Tenant::find($id);
        return $response;
    }
    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $tenant = Tenant::create($data);
            if(!$tenant){
                throw new \Exception('Error creating tenant');
            }
            $response = $this->getById($tenant->id);
            DB::commit();

            return $response;
        } catch (\Exception $e) {
            throw new \Exception('Error creating tenant: ' . $e->getMessage());
        }
    }
    public function update(int $id, array $data)
    {
        try {
            DB::beginTransaction();
            $tenant = Tenant::find($id);
            if(!$tenant){
                throw new \Exception('Tenant not found');
            }
            $tenant->update($data);
            $response = $this->getById($tenant->id);
            DB::commit();

            return $response;
        } catch (\Exception $e) {
            throw new \Exception('Error updating tenant: ' . $e->getMessage());
        }
    }
    public function delete(int $id)
    {
        try {
            DB::beginTransaction();
            $tenant = Tenant::find($id);
            if(!$tenant){
                throw new \Exception('Tenant not found');
            }
            $tenant->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Error deleting tenant: ' . $e->getMessage());
        }
    }
}
