<?php
namespace Database\Seeders;

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Matikan foreign key check sementara agar truncate aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('Project_Saya')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('Project_Saya')->insert([
            [
                'nama' => 'Warkop QR - Sistem Pemesanan & POS Digital',
                'image_path' => 'readme_banner.png',
                'caption' => 'Aplikasi Sistem Pemesanan & POS Digital yang dibangun menggunakan Laravel 12 dengan pengamanan penuh terhadap celah SQL Injection, CSRF Protection, Request Validation.',
                'Work_Story' => 'Dalam pengembangan Warkop QR, saya merancang arsitektur backend yang andal menggunakan Laravel 12 dan basis data MySQL. Keamanan serta integritas data dijaga secara ketat melalui penerapan manajemen session dan request validation yang terstruktur. Di sisi frontend, saya mengombinasikan Tailwind CSS dan Alpine.js untuk menghadirkan interaksi asinkronus, sehingga daftar menu dapat termuat secara instan dan seamless di perangkat seluler pelanggan tanpa perlu memuat ulang halaman.',
                'Main_Features' => "Pemesanan Menu Mandiri secara instan via scan QR Code Meja unik.\nDashboard Kasir & Pemantauan dapur dengan status pesanan real-time.\nLaporan Keuangan otomatis harian, mingguan, dan bulanan.\nSistem Manajemen Stok Inventaris bahan baku/menu real-time.\nSecurity Alert internal and filter XSS / SQL Injection bawaan Laravel.",
                'Kategori' => 'web',
                'Tanggal_Proyek' => 'Maret - Mei 2026',
                'Role' => 'Full Stack Developer',
                'Teknologi' => 'Laravel 12,Vanilla JavaScript,Bootstrap,PHP,MySQL,Tailwind CSS',
                'url_code' => 'https://github.com/antoperdi/warkop_QR',
                'url_demo' => 'https://example.com/demo-warkop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dashboard Finansial Modern',
                'image_path' => 'IMG_20260226_045149_015.webp',
                'caption' => 'Desain antarmuka dashboard keuangan interaktif dengan konsep Glassmorphism, berfokus pada kemudahan membaca visualisasi grafik data.',
                'Work_Story' => 'Tantangan utama proyek ini adalah menyederhanakan penyajian data transaksi finansial yang padat. Saya melakukan User Research terlebih dahulu untuk menyusun tata letak modular. Menggunakan konsep visual Glassmorphism berpalet warna gelap kontras (#293681 dan #95CCDD) untuk memfokuskan pandangan pengguna pada angka neraca keuangan penting. Seluruh aset didokumentasikan ke dalam Design System yang lengkap.',
                'Main_Features' => "Desain antarmuka Glassmorphism premium gelap modern.\nStruktur grid modular yang dapat dipindahkan posisinya (drag & drop UI).\nDesain visualisasi diagram lingkaran dan garis interaktif.\nPustaka komponen UI lengkap (Colors, Typography, Icons, Buttons).",
                'Kategori' => 'design',
                'Tanggal_Proyek' => 'Maret - Mei 2026',
                'Role' => 'UI/UX Designer',
                'Teknologi' => 'Figma,UI/UX,Glassmorphism,Design System',
                'url_code' => 'https://github.com/rakhmat-sam/financial-dashboard-ui',
                'url_demo' => 'https://example.com/demo-dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sistem Kesehatan Laboratorium UPTD Labkes Kota Pangkalpinang',
                'image_path' => 'halaman login.png',
                'caption' => 'Aplikasi Sistem Informasi Kesehatan Laboratorium UPTD Labkes Kota Pangkalpinang merupakan solusi digital berbasis web yang dirancang untuk mengintegrasikan dan mengoptimalkan seluruh alur pelayanan laboratorium kesehatan masyarakat...',
                'Work_Story' => 'Dalam sistem kesehatan laboratorium ini, saya berfokus penuh pada sisi performa muat halaman (Performance Optimization) dan Search Engine Optimization (SEO). Frontend dibangun dengan HTML5 semantik dan Vanilla CSS murni untuk menjaga ukuran berkas agar seminimal mungkin. Saya mengimplementasikan teknik Lazy Loading gambar yang ketat dan pre-fetching link navigasi sehingga skor Core Web Vitals mencapai 98% di Google Lighthouse.',
                'Main_Features' => "Pemuatan berita asinkronus berbasis kategori tanpa reload halaman.\nOptimasi SEO on-page: Metadata dinamis, Open Graph, dan JSON-LD Structured Data.\nSistem caching asinkronus client-side untuk memuat halaman secara instan.\nTampilan responsif penuh di berbagai ukuran layar.",
                'Kategori' => 'web',
                'Tanggal_Proyek' => 'April - Juli 2026',
                'Role' => 'Frontend Developer',
                'Teknologi' => 'HTML5,JavaScript ES6,SEO Optimization',
                'url_code' => 'https://github.com/rakhmat-sam/realtime-news-portal',
                'url_demo' => 'https://example.com/demo-portal',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
