<?php

namespace Database\Seeders;

use App\Enum\StatusEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // SYSTEM USER
        User::updateOrCreate(
            ['email' => 'suporte@gmail.com'],
            [
                'id' => (string) Str::uuid(),
                'status' => StatusEnum::ACTIVE->value,
                'name' => 'Suporte Sistema',
                'type' => 'SYSTEM',
                'password' => Hash::make('@suporte'),
            ]
        );

        // TENANT USERS
        $users = [
            [
                'name' => 'Admin Tenant A',
                'email' => 'suporte1@empresa.com',
                'type' => 'TENANT',
                'password' => '@suporte',
            ],
            [
                'name' => 'Usuário Tenant A',
                'email' => 'userA@empresa.com',
                'type' => 'TENANT',
                'password' => '@user',
            ],
            [
                'name' => 'Admin Tenant B',
                'email' => 'suporteB@empresa.com',
                'type' => 'TENANT',
                'password' => '@suporte',
            ],
            [
                'name' => 'Usuário Tenant B',
                'email' => 'userB@empresa.com',
                'type' => 'TENANT',
                'password' => '@user',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'id' => (string) Str::uuid(),
                    'status' => StatusEnum::ACTIVE->value,
                    'name' => $data['name'],
                    'type' => $data['type'],
                    'password' => Hash::make($data['password']),
                ]
            );
        }
    }
}
