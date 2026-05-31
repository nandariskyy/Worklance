<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        // Update namajasa berdasarkan id_layanan
        $data = [
            1  => 'Desain Logo Cepat',
            2  => 'Desain Banner Banyak Ukuran',
            3  => 'Service Elektronik Panggilan',
            4  => 'Service AC Rumah Cepat Tanggap',
            5  => 'Foto Prewedding Aesthetic',
            6  => 'Dokumentasi Acara Lengkap',
            7  => 'Pembuatan Website Fullstack',
            8  => 'Aplikasi Desktop Custom',
            9  => 'UI/UX Design Modern',
            10 => 'Bersih Rumah 3 jam selesai',
            11 => 'Tukang Cat Profesional',
            12 => 'MC Acara Formal & Santai',
            13 => 'Desain Konten Tiktok',
            14 => 'Edit Foto 1 jam selesai',
            15 => 'Edit Video Sederhana & Keren',
            16 => 'Jasa Kelistrik Rumah Dijamin Aman ',
            17 => 'Foto Produk UMKM Free Cetak',
            18 => 'Penyanyi Solo Wedding',
            19 => 'Foto/Vidio Kekinian',
        ];

        foreach ($data as $id => $nama) {
            DB::table('layanan')
                ->where('id_layanan', $id)
                ->update(['namajasa' => $nama]);
        }
    }
}