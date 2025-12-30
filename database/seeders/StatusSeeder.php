<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();
        foreach(config("constantes.status") as $chave => $valor){
            Status::create([
                'tenant_id' => $tenant->id,
                'name' => $chave,

            ]);

        }
    }
}
