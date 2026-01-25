<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class BranchUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();
        // Branches
        $matriz = Branch::where('code', '0001')->first();
        $filialSp = Branch::where('code', '0002')->first();
        $filialSc = Branch::where('code', '0003')->first();

        $tenantAdmin = User::where('email', 'admin@empresa.com')->first();
        $tenantUser = User::where('email', 'user@empresa.com')->first();
        $tenantUser = User::where('email', 'user2@empresa.com')->first();

        $tenantUser->branches()->syncWithoutDetaching([
            $matriz->id => [
                'tenant_id' => $tenant->id,
            ],
        ]);

    }
}
