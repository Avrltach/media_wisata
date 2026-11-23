<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = 'admin@mediawisata.com';

        if (User::where('email', $adminEmail)->exists()) {
            $this->command->info("Admin user sudah ada (email: {$adminEmail}). Skip seeding.");
            return;
        }

        User::create([
            'name' => 'Admin Media Wisata',
            'email' => $adminEmail,
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Karanglewas, Kabupaten Banyumas, Jawa Tengah',
            'email_verified_at' => now(),
        ]);

        $this->command->info("Admin user created:");
        $this->command->info("  Email: {$adminEmail}");
        $this->command->info("  Password: password123");
        $this->command->warn("  ⚠️  Ganti password setelah login pertama!");
    }
}