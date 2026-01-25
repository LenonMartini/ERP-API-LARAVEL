<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchFiscalSetting;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class BranchFiscalSettingSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        Branch::all()->each(function ($branch) use ($tenant) {

            BranchFiscalSetting::create([
                'tenant_id' => $tenant->id,
                'branch_id' => $branch->id,
                'environment' => 'HOMOLOGATION',

                // NF-e
                'nfe_series' => '1',
                'nfe_last_number' => 0,

                // NFC-e
                'nfce_series' => '1',
                'nfce_last_number' => 0,
                'nfce_csc_id' => '000001',
                'nfce_csc_code' => 'CSC_TESTE_123456',
            ]);
        });
    }
}
