<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username' => 'BossAdmin',
            'email' => 'admin@dreamy.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'nomor_hp' => '081234567890',
            'email_verified_at' => now(),
        ]);

        User::create([
            'username' => 'PelangganSetia',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'pelanggan',
            'nomor_hp' => '089876543210',
            'email_verified_at' => now(),
        ]);
    }
}
