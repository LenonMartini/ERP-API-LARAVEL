<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxRegimeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tax_regimes')->insert([
            [
                'tenant_id' => 1,
                'code' => 'SIMPLES',
                'description' => 'Simples Nacional',
            ],
            [
                'tenant_id' => 1,
                'code' => 'PRESUMIDO',
                'description' => 'Lucro Presumido',
            ],
            [
                'tenant_id' => 1,
                'code' => 'REAL',
                'description' => 'Lucro Real',
            ],
        ]);
    }
}
