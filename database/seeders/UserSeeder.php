<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $status = Status::first();
        DB::table('users')->insert([
            [
                'id' => (string) Str::uuid(),
                'tenant_id' => null,
                'status_id' => $status->id,
                'name' => 'suporte',
                'email' => 'suporte@gmail.com',
                'type' => 'SYSTEM',
                'password' => Hash::make('@suporte'), // password
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
