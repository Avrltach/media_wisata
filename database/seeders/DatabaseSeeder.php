<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting Media Wisata database seeding...');

        $this->call([
            AdminUserSeeder::class,
            CompanyProfileSeeder::class,
            BankAccountSeeder::class,
            FaqSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('==============================================');
        $this->command->info('Media Wisata database seeding completed!');
        $this->command->info('==============================================');
        $this->command->info('');
        $this->command->info('Admin login credentials:');
        $this->command->info('  URL:      http://localhost:8000/admin/login');
        $this->command->info('  Email:    admin@mediawisata.com');
        $this->command->info('  Password: password123');
        $this->command->info('');
    }
}