<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => '一般ユーザー',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $seller1 = User::factory()->create([
            'email' => 'seller1@example.com',
            'name' => '出品者A',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $seller2 = User::factory()->create([
            'email' => 'seller2@example.com',
            'name' => '出品者B',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $NoSellerUser = User::factory()->create([
            'email' => 'no_seller@example.com',
            'name' => '未紐づきユーザー',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
    }
}
