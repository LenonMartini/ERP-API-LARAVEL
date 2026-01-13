<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserPreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        DB::table('user_preferences')->insert([
            [
                'user_id' => $user->id,
                'key' => 'theme',
                'value' => 'dark',
            ]
            ]);
    }
}
