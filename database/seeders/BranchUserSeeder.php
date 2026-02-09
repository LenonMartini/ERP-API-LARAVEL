<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class BranchUserSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        $matriz = Branch::where('code', 1)->first();
        $filialSp = Branch::where('code', 2)->first();
        $filialSc = Branch::where('code', 3)->first();

        // Usuários existentes no UserSeeder
        $tenantAdminA = User::where('email', 'suporte1@empresa.com')->first();
        $tenantUserA = User::where('email', 'userA@empresa.com')->first();

        $tenantAdminB = User::where('email', 'suporteB@empresa.com')->first();
        $tenantUserB = User::where('email', 'userB@empresa.com')->first();

        if (
            ! $tenant ||
            ! $matriz ||
            ! $filialSp ||
            ! $filialSc ||
            ! $tenantAdminA ||
            ! $tenantUserA ||
            ! $tenantAdminB ||
            ! $tenantUserB
        ) {
            throw new \Exception('Dados obrigatórios não encontrados para o BranchUserSeeder');
        }

        // Tenant A
        foreach ([$tenantAdminA, $tenantUserA] as $user) {
            $user->branches()->syncWithoutDetaching([
                $matriz->id => ['tenant_id' => $tenant->id],
                $filialSp->id => ['tenant_id' => $tenant->id],
            ]);
        }

        // Tenant B
        foreach ([$tenantAdminB, $tenantUserB] as $user) {
            $user->branches()->syncWithoutDetaching([
                $matriz->id => ['tenant_id' => $tenant->id],
                $filialSc->id => ['tenant_id' => $tenant->id],
            ]);
        }
    }
}
