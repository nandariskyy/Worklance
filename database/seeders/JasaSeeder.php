<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JasaSeeder extends Seeder
{
    /**
     * Seed data master jasa (sub-kategori layanan).
     */
    public function run(): void
    {
        DB::table('jasa')->insert([
            // Kategori 1: Desain & Kreatif
            ['id_jasa' => 1,  'id_kategori' => 1, 'nama_jasa' => 'Desain Logo'],
            ['id_jasa' => 2,  'id_kategori' => 1, 'nama_jasa' => 'Desain Poster / Banner'],
            ['id_jasa' => 3,  'id_kategori' => 1, 'nama_jasa' => 'Desain Konten Sosial Media'],
            ['id_jasa' => 4,  'id_kategori' => 1, 'nama_jasa' => 'Editing Foto'],
            ['id_jasa' => 5,  'id_kategori' => 1, 'nama_jasa' => 'Editing Video Sederhana'],

            // Kategori 2: Teknisi & Perbaikan
            ['id_jasa' => 6,  'id_kategori' => 2, 'nama_jasa' => 'Service Alat Elektronik'],
            ['id_jasa' => 7,  'id_kategori' => 2, 'nama_jasa' => 'Service AC'],
            ['id_jasa' => 8,  'id_kategori' => 2, 'nama_jasa' => 'Kelistrikan Rumah'],

            // Kategori 3: Fotografi & Videografi
            ['id_jasa' => 9,  'id_kategori' => 3, 'nama_jasa' => 'Foto Prewedding'],
            ['id_jasa' => 10, 'id_kategori' => 3, 'nama_jasa' => 'Dokumentasi Acara'],
            ['id_jasa' => 11, 'id_kategori' => 3, 'nama_jasa' => 'Foto Produk UMKM'],
            ['id_jasa' => 12, 'id_kategori' => 3, 'nama_jasa' => 'Video Shooting Event'],

            // Kategori 4: Pendidikan & Les Privat
            ['id_jasa' => 13, 'id_kategori' => 4, 'nama_jasa' => 'Les Matematika'],
            ['id_jasa' => 14, 'id_kategori' => 4, 'nama_jasa' => 'Les Bahasa Inggris'],
            ['id_jasa' => 15, 'id_kategori' => 4, 'nama_jasa' => 'Les SD/SMP/SMA'],
            ['id_jasa' => 16, 'id_kategori' => 4, 'nama_jasa' => 'Les Mengaji'],

            // Kategori 5: IT & Digital
            ['id_jasa' => 17, 'id_kategori' => 5, 'nama_jasa' => 'Pembuatan Website'],
            ['id_jasa' => 18, 'id_kategori' => 5, 'nama_jasa' => 'Pembuatan Aplikasi Desktop'],
            ['id_jasa' => 19, 'id_kategori' => 5, 'nama_jasa' => 'Pembuatan Aplikasi Mobile'],
            ['id_jasa' => 20, 'id_kategori' => 5, 'nama_jasa' => 'UI/UX Design'],

            // Kategori 6: Rumah Tangga
            ['id_jasa' => 21, 'id_kategori' => 6, 'nama_jasa' => 'Bersih-bersih Rumah'],
            ['id_jasa' => 22, 'id_kategori' => 6, 'nama_jasa' => 'Cuci Setrika'],
            ['id_jasa' => 31, 'id_kategori' => 6, 'nama_jasa' => 'Masak'],

            // Kategori 7: Tukang & Konstruksi
            ['id_jasa' => 23, 'id_kategori' => 7, 'nama_jasa' => 'Tukang Bangunan'],
            ['id_jasa' => 24, 'id_kategori' => 7, 'nama_jasa' => 'Tukang Cat Rumah'],
            ['id_jasa' => 25, 'id_kategori' => 7, 'nama_jasa' => 'Tukang Kayu'],
            ['id_jasa' => 26, 'id_kategori' => 7, 'nama_jasa' => 'Renovasi Kecil'],

            // Kategori 8: Event & Hiburan
            ['id_jasa' => 27, 'id_kategori' => 8, 'nama_jasa' => 'MC Acara'],
            ['id_jasa' => 28, 'id_kategori' => 8, 'nama_jasa' => 'Penyanyi / Band'],
            ['id_jasa' => 29, 'id_kategori' => 8, 'nama_jasa' => 'Dekorasi Acara'],
            ['id_jasa' => 30, 'id_kategori' => 8, 'nama_jasa' => 'Wedding Organizer'],
        ]);
    }
}
