<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Seed data master kategori jasa.
     */
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['id_kategori' => 1, 'nama_kategori' => 'Desain & Kreatif'],
            ['id_kategori' => 2, 'nama_kategori' => 'Teknisi & Perbaikan'],
            ['id_kategori' => 3, 'nama_kategori' => 'Fotografi & Videografi'],
            ['id_kategori' => 4, 'nama_kategori' => 'Pendidikan & Les Privat'],
            ['id_kategori' => 5, 'nama_kategori' => 'IT & Digital'],
            ['id_kategori' => 6, 'nama_kategori' => 'Rumah Tangga'],
            ['id_kategori' => 7, 'nama_kategori' => 'Tukang & Konstruksi'],
            ['id_kategori' => 8, 'nama_kategori' => 'Event & Hiburan'],
        ]);
    }
}
