<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TenantSeeder::class,
            StatusSeeder::class,
            UserSeeder::class,
            UserPreferenceSeeder::class,
            RolePermissionSeeder::class,
            SuperAdminSeeder::class,
            TaxRegimeSeeder::class,
            TenantBranchSeeder::class,
            BranchFiscalSettingSeeder::class,
            BranchUserSeeder::class,
            BranchCertificateSeeder::class,
        ]);
    }
}
