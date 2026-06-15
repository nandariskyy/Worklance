<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    /**
     * Seed data dummy layanan freelancer.
     */
    public function run(): void
    {
        DB::table('layanan')->insert([
            ['id_layanan' => 1,  'id_pengguna' => 4,  'id_jasa' => 1,  'id_satuan' => 5, 'tarif' => 500000,  'deskripsi' => 'Desain logo profesional dan cepat',          'namajasa' => 'Desain Logo Cepat',                    'gambar_cover' => null],
            ['id_layanan' => 2,  'id_pengguna' => 4,  'id_jasa' => 2,  'id_satuan' => 5, 'tarif' => 300000,  'deskripsi' => 'Desain banner menarik',                       'namajasa' => 'Desain Banner Banyak Ukuran',           'gambar_cover' => null],
            ['id_layanan' => 3,  'id_pengguna' => 5,  'id_jasa' => 6,  'id_satuan' => 1, 'tarif' => 150000,  'deskripsi' => 'Service elektronik panggilan',                 'namajasa' => 'Service Elektronik Panggilan',          'gambar_cover' => null],
            ['id_layanan' => 4,  'id_pengguna' => 5,  'id_jasa' => 7,  'id_satuan' => 4, 'tarif' => 250000,  'deskripsi' => 'Service AC rumah',                              'namajasa' => 'Service AC Rumah Cepat Tanggap',        'gambar_cover' => null],
            ['id_layanan' => 5,  'id_pengguna' => 6,  'id_jasa' => 9,  'id_satuan' => 5, 'tarif' => 2000000, 'deskripsi' => 'Foto prewedding aesthetic',                     'namajasa' => 'Foto Prewedding Aesthetic',             'gambar_cover' => null],
            ['id_layanan' => 6,  'id_pengguna' => 6,  'id_jasa' => 10, 'id_satuan' => 5, 'tarif' => 1500000, 'deskripsi' => 'Dokumentasi acara lengkap',                     'namajasa' => 'Dokumentasi Acara Lengkap',             'gambar_cover' => null],
            ['id_layanan' => 7,  'id_pengguna' => 7,  'id_jasa' => 18, 'id_satuan' => 5, 'tarif' => 3000000, 'deskripsi' => 'Pembuatan website fullstack',                   'namajasa' => 'Pembuatan Website Fullstack',           'gambar_cover' => null],
            ['id_layanan' => 8,  'id_pengguna' => 7,  'id_jasa' => 19, 'id_satuan' => 5, 'tarif' => 2500000, 'deskripsi' => 'Aplikasi desktop custom',                       'namajasa' => 'Aplikasi Desktop Custom',               'gambar_cover' => null],
            ['id_layanan' => 9,  'id_pengguna' => 4,  'id_jasa' => 20, 'id_satuan' => 5, 'tarif' => 700000,  'deskripsi' => 'UI UX modern',                                  'namajasa' => 'UI/UX Design Modern',                   'gambar_cover' => null],
            ['id_layanan' => 10, 'id_pengguna' => 5,  'id_jasa' => 21, 'id_satuan' => 4, 'tarif' => 100000,  'deskripsi' => 'Bersih rumah harian',                            'namajasa' => 'Bersih Rumah 3 jam selesai',            'gambar_cover' => null],
            ['id_layanan' => 11, 'id_pengguna' => 6,  'id_jasa' => 24, 'id_satuan' => 5, 'tarif' => 500000,  'deskripsi' => 'Tukang cat profesional',                        'namajasa' => 'Tukang Cat Profesional',                'gambar_cover' => null],
            ['id_layanan' => 12, 'id_pengguna' => 7,  'id_jasa' => 27, 'id_satuan' => 5, 'tarif' => 1000000, 'deskripsi' => 'MC acara formal & santai',                      'namajasa' => 'MC Acara Formal & Santai',              'gambar_cover' => null],
            ['id_layanan' => 13, 'id_pengguna' => 10, 'id_jasa' => 3,  'id_satuan' => 5, 'tarif' => 400000,  'deskripsi' => 'Desain konten sosial media kreatif',             'namajasa' => 'Desain Konten Tiktok',                  'gambar_cover' => null],
            ['id_layanan' => 14, 'id_pengguna' => 10, 'id_jasa' => 4,  'id_satuan' => 5, 'tarif' => 250000,  'deskripsi' => 'Editing foto profesional',                      'namajasa' => 'Edit Foto 1 jam selesai',               'gambar_cover' => null],
            ['id_layanan' => 15, 'id_pengguna' => 4,  'id_jasa' => 5,  'id_satuan' => 5, 'tarif' => 300000,  'deskripsi' => 'Editing video sederhana cepat',                  'namajasa' => 'Edit Video Sederhana & Keren',          'gambar_cover' => null],
            ['id_layanan' => 16, 'id_pengguna' => 5,  'id_jasa' => 8,  'id_satuan' => 1, 'tarif' => 200000,  'deskripsi' => 'Jasa kelistrikan rumah',                         'namajasa' => 'Jasa Kelistrik Rumah Dijamin Aman ',    'gambar_cover' => null],
            ['id_layanan' => 17, 'id_pengguna' => 6,  'id_jasa' => 11, 'id_satuan' => 5, 'tarif' => 800000,  'deskripsi' => 'Foto produk untuk UMKM',                        'namajasa' => 'Foto Produk UMKM Free Cetak',           'gambar_cover' => null],
            ['id_layanan' => 18, 'id_pengguna' => 7,  'id_jasa' => 28, 'id_satuan' => 5, 'tarif' => 2500000, 'deskripsi' => 'Penyanyi untuk acara wedding',                   'namajasa' => 'Penyanyi Solo Wedding',                 'gambar_cover' => null],
            ['id_layanan' => 19, 'id_pengguna' => 1,  'id_jasa' => 1,  'id_satuan' => 1, 'tarif' => 150000,  'deskripsi' => 'Update testing',                                 'namajasa' => 'Foto/Vidio Kekinian',                   'gambar_cover' => null],
            ['id_layanan' => 20, 'id_pengguna' => 1,  'id_jasa' => 2,  'id_satuan' => 1, 'tarif' => 150000,  'deskripsi' => 'Update testing',                                 'namajasa' => null,                                    'gambar_cover' => null],
            ['id_layanan' => 21, 'id_pengguna' => 5,  'id_jasa' => 22, 'id_satuan' => 4, 'tarif' => 100000,  'deskripsi' => 'Bersih rumah harian',                            'namajasa' => null,                                    'gambar_cover' => null],
            ['id_layanan' => 22, 'id_pengguna' => 4,  'id_jasa' => 27, 'id_satuan' => null, 'tarif' => 2500000, 'deskripsi' => 'MC Acara Sunatan',                            'namajasa' => 'MC Acara Sunatan',                      'gambar_cover' => 'covers/V3at4pJVFb6wJSRXVob2Vcqs2P06QP61VeJr7dO3.png'],
            ['id_layanan' => 23, 'id_pengguna' => 4,  'id_jasa' => 31, 'id_satuan' => 4, 'tarif' => 200000,  'deskripsi' => 'Jasa memasak',                                   'namajasa' => 'Jasa Masak',                            'gambar_cover' => null],
            ['id_layanan' => 24, 'id_pengguna' => 2,  'id_jasa' => 14, 'id_satuan' => 4, 'tarif' => 100000,  'deskripsi' => 'Les Bahasa Inggris untuk anak SMP',              'namajasa' => 'Les Bahasa Inggris SMP',                'gambar_cover' => null],
            ['id_layanan' => 25, 'id_pengguna' => 12, 'id_jasa' => 31, 'id_satuan' => 2, 'tarif' => 50000,   'deskripsi' => 'Saya adalah tukang masak rumahan',               'namajasa' => 'Jasa Masakan Rumahan Cepat',            'gambar_cover' => null],
        ]);
    }
}
