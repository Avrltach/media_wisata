<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        if (CompanyProfile::exists()) {
            $this->command->info('Company profile sudah ada. Skip seeding.');
            return;
        }

        CompanyProfile::create([
            'name' => 'Media Wisata',
            'description' => 'Media Wisata adalah perusahaan jasa perjalanan wisata dan transportasi yang berlokasi di Karanglewas, Kabupaten Banyumas. Kami menyediakan layanan paket wisata, sewa transportasi, dan event organizer dengan komitmen memberikan pengalaman perjalanan yang aman, nyaman, dan berkesan.',
            'address' => 'Karanglewas, Kabupaten Banyumas, Jawa Tengah, Indonesia',
            'phone' => '0281-123456',
            'email' => 'info@mediawisata.com',
            'whatsapp' => '6281234567890',
            'instagram' => 'https://instagram.com/mediawisata',
            'facebook' => 'https://facebook.com/mediawisata',
            'tiktok' => 'https://tiktok.com/@mediawisata',
            'maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.123456!2d109.123456!3d-7.123456',
            'logo_path' => null,
            'operating_hours' => 'Senin-Sabtu, 08:00 - 17:00 WIB',
            'founded_year' => 2015,
        ]);

        $this->command->info('Company profile created for Media Wisata.');
    }
}