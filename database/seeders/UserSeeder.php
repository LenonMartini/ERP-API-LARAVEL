<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $status = Status::first();
        $tenant = Tenant::first(); // tenant criado no seed anterior
        DB::table('users')->insert(
            [
                'id' => (string) Str::uuid(),
                'tenant_id' => null,
                'status_id' => $status->id,
                'name' => 'Suporte',
                'email' => 'suporte@gmail.com',
                'type' => 'SYSTEM',
                'password' => Hash::make('@suporte'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );

        DB::table('users')->insert([
            // SYSTEM

            // TENANT ADMIN
            [
                'id' => (string) Str::uuid(),
                'tenant_id' => $tenant->id,
                'status_id' => $status->id,
                'name' => 'Admin Empresa',
                'email' => 'admin@empresa.com',
                'type' => 'TENANT',
                'password' => Hash::make('@admin'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // TENANT USER
            [
                'id' => (string) Str::uuid(),
                'tenant_id' => $tenant->id,
                'status_id' => $status->id,
                'name' => 'Usuário Filial',
                'email' => 'user@empresa.com',
                'type' => 'TENANT',
                'password' => Hash::make('@user'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // TENANT USER
            [
                'id' => (string) Str::uuid(),
                'tenant_id' => $tenant->id,
                'status_id' => $status->id,
                'name' => 'Usuário Filial2',
                'email' => 'user2@empresa.com',
                'type' => 'TENANT',
                'password' => Hash::make('@user'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
