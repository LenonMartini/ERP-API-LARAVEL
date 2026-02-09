<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantUserSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::orderBy('id')->get();
        $tenantUsers = User::where('type', 'TENANT')->orderBy('email')->get();

        if ($tenants->isEmpty() || $tenantUsers->isEmpty()) {
            throw new \Exception('Tenants ou usuários TENANT não encontrados');
        }

        // Distribui usuários TENANT entre tenants (1 usuário -> 1 tenant)
        $tenantIndex = 0;

        foreach ($tenantUsers as $user) {
            $tenant = $tenants[$tenantIndex];

            DB::table('tenant_users')->updateOrInsert(
                ['user_id' => $user->id], // 👈 chave única
                [
                    'tenant_id' => $tenant->id,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            // Próximo tenant (round-robin)
            $tenantIndex = ($tenantIndex + 1) % $tenants->count();
        }
    }
}
