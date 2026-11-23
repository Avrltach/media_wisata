<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara melakukan pemesanan paket wisata?',
                'answer' => 'Untuk melakukan pemesanan, pilih paket wisata yang diinginkan di halaman Paket, klik tombol "Pesan Sekarang", lalu login atau registrasi. Setelah itu, isi form pemesanan dengan data diri dan tanggal keberangkatan, lalu lakukan pembayaran DP sebesar 30% dari total harga paket melalui Midtrans.',
                'category' => 'Pemesanan',
                'sort_order' => 1,
            ],
            [
                'question' => 'Berapa nominal DP yang harus dibayar?',
                'answer' => 'DP (Down Payment) yang harus dibayar adalah sebesar 30% dari total harga paket. Sisa pembayaran (pelunasan) dapat dilakukan sebelum tanggal keberangkatan melalui transfer manual ke rekening bank Media Wisata.',
                'category' => 'Pembayaran',
                'sort_order' => 2,
            ],
            [
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => 'Untuk pembayaran DP, kami melayani melalui Midtrans yang mendukung berbagai metode pembayaran seperti Virtual Account (BCA, Mandiri, BNI, BRI), QRIS, e-wallet (GoPay, OVO, DANA), dan kartu kredit. Untuk pelunasan, dilakukan melalui transfer manual ke rekening bank Media Wisata.',
                'category' => 'Pembayaran',
                'sort_order' => 3,
            ],
            [
                'question' => 'Bagaimana cara melunasi pembayaran?',
                'answer' => 'Setelah DP terbayar, Anda akan menerima email konfirmasi beserta link untuk melihat detail pesanan. Pada halaman detail pesanan terdapat informasi rekening bank tujuan transfer dan form upload bukti pembayaran. Setelah upload bukti, admin akan memverifikasi dalam 1x24 jam.',
                'category' => 'Pembayaran',
                'sort_order' => 4,
            ],
            [
                'question' => 'Apakah saya bisa membatalkan pesanan?',
                'answer' => 'Pembatalan pesanan dapat dilakukan dengan menghubungi admin Media Wisata. Kebijakan refund mengikuti ketentuan: pembatalan lebih dari 14 hari sebelum keberangkatan mendapat refund 50% dari DP, pembatalan kurang dari 14 hari tidak mendapat refund DP.',
                'category' => 'Pembatalan',
                'sort_order' => 5,
            ],
            [
                'question' => 'Apakah saya bisa memesan untuk rombongan?',
                'answer' => 'Ya, Anda bisa memesan untuk rombongan. Pada form pemesanan, isi jumlah peserta sesuai kebutuhan. Untuk pesanan di atas 10 peserta, mohon hubungi admin kami untuk mendapatkan penawaran harga khusus.',
                'category' => 'Pemesanan',
                'sort_order' => 6,
            ],
            [
                'question' => 'Apakah Media Wisata menyediakan layanan selain paket wisata?',
                'answer' => 'Ya, Media Wisata juga menyediakan layanan sewa transportasi (bus, MPV, shuttle) dan jasa event organizer untuk company gathering, family gathering, seminar, workshop, dan acara lainnya. Silakan hubungi kami untuk penawaran custom.',
                'category' => 'Layanan',
                'sort_order' => 7,
            ],
            [
                'question' => 'Apakah harga paket sudah termasuk semua?',
                'answer' => 'Setiap paket memiliki detail fasilitas yang termasuk dan tidak termasuk. Silakan lihat pada halaman detail paket untuk informasi lengkap. Umumnya harga sudah termasuk transportasi, akomodasi, makan sesuai itinerary, dan pemandu wisata.',
                'category' => 'Layanan',
                'sort_order' => 8,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                array_merge($faq, ['is_published' => true])
            );
        }

        $this->command->info('FAQs seeded: ' . count($faqs) . ' entries.');
    }
}