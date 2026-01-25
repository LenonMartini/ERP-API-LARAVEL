<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BranchCertificateSeeder extends Seeder
{
    public function run(): void
    {
        Branch::all()->each(function ($branch) {

            DB::table('branch_certificates')->insert([
                'tenant_id' => $branch->tenant_id,
                'branch_id' => $branch->id,

                'name' => 'Certificado Fiscal - '.$branch->code,

                'type' => 'A1',
                'file_path' => 'certificates/'.Str::uuid().'.pfx',
                'password' => Crypt::encryptString('senha_teste'),

                'expires_at' => now()->addYear(),

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
