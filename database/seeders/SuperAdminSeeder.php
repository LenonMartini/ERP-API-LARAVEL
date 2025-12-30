<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // 🔥 IMPORTANTE
use Spatie\Permission\Models\Role; // 🔥 IMPORTANTE
use Spatie\Permission\Models\Permission; // 🔥 IMPORTANTE
use Spatie\Permission\PermissionRegistrar;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔥 Limpa cache do Spatie
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 🔹 Busca o primeiro usuário
        $user = User::orderBy('created_at')->first();

        if (! $user) {
            $this->command->warn('Nenhum usuário encontrado. Super-admin não criado.');
            return;
        }

        // 🔹 Cria ou recupera o role super-admin
        $role = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        // 🔹 Garante todas as permissões
        $role->syncPermissions(Permission::all());

        // 🔹 Vincula o role ao usuário
        if (! $user->hasRole('super-admin')) {
            $user->assignRole($role);
        }

        $this->command->info("Usuário {$user->email} definido como SUPER-ADMIN.");
    }
}
