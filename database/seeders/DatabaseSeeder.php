<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bikin Akun ADMIN (Buat Login Filament)
        User::factory()->create([
            'name' => 'Admin Tiket',
            'email' => 'admin@admin.com',
            'role' => 'admin', 
            'password' => Hash::make('password123'), 
            'email_verified_at' => now(),
        ]);

        // 2. Bikin Akun CUSTOMER (Buat Tes Login di Frontend)
        User::factory()->create([
            'name' => 'User Customer',
            'email' => 'user@user.com',
            'role' => 'customer',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // 3. (Opsional) Bikin 10 user random tambahan buat rame-ramein
        User::factory(10)->create();
    }
}