<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantBranchSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        // MATRIZ
        $matriz = Branch::create([
            'tenant_id' => $tenant->id,
            'status_id' => 1,
            'name' => 'Empresa Exemplo LTDA',
            'trade_name' => 'Empresa Exemplo',
            'code' => '0001',
            'cnpj' => '12345678000199',
            'state_registration' => '123456789',
            'municipal_registration' => null,
            'crt_id' => 1,
            'zip_code' => '80000000',
            'address' => 'Rua Central',
            'address_number' => '100',
            'neighborhood' => 'Centro',
            'city' => 'Curitiba',
            'ibge_city_code' => '4106902',
            'state' => 'PR',
            'phone' => '41999999999',
        ]);

        // FILIAL 01
        $filial01 = Branch::create([
            'tenant_id' => $tenant->id,
            'status_id' => 1,
            'name' => 'Empresa Exemplo Filial SP',
            'trade_name' => 'Empresa Exemplo SP',
            'code' => '0002',
            'cnpj' => '12345678000270',
            'state_registration' => '987654321',
            'municipal_registration' => null,
            'crt_id' => 1,
            'zip_code' => '01000000',
            'address' => 'Av Paulista',
            'address_number' => '1000',
            'neighborhood' => 'Bela Vista',
            'city' => 'São Paulo',
            'ibge_city_code' => '3550308',
            'state' => 'SP',
            'phone' => '11999999999',
        ]);

        // FILIAL 02
        $filial02 = Branch::create([
            'tenant_id' => $tenant->id,
            'status_id' => 1,
            'name' => 'Empresa Exemplo Filial SC',
            'trade_name' => 'Empresa Exemplo SC',
            'code' => '0003',
            'cnpj' => '12345678000350',
            'state_registration' => '456789123',
            'municipal_registration' => null,
            'crt_id' => 1,
            'zip_code' => '88000000',
            'address' => 'Rua das Flores',
            'address_number' => '500',
            'neighborhood' => 'Centro',
            'city' => 'Florianópolis',
            'ibge_city_code' => '4205407',
            'state' => 'SC',
            'phone' => '48999999999',
        ]);
    }
}
