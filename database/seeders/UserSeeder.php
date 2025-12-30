<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::first();
        $status = Status::first();
        DB::table('users')->insert([
            [
                'id' => (string) Str::uuid(),
                'tenant_id' => $tenant->id,
                'status_id' => $status->id,
                'name' => 'suporte',
                'email' => 'suporte@gmail.com',
                'password' => Hash::make('@suporte'), // password
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
