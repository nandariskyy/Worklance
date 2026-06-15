<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    /**
     * Seed data master satuan layanan.
     */
    public function run(): void
    {
        DB::table('satuan')->insert([
            ['id_satuan' => 1, 'nama_satuan' => 'Unit'],
            ['id_satuan' => 2, 'nama_satuan' => 'Jam'],
            ['id_satuan' => 3, 'nama_satuan' => 'Paket'],
            ['id_satuan' => 4, 'nama_satuan' => 'Hari'],
            ['id_satuan' => 5, 'nama_satuan' => 'Project'],
        ]);
    }
}
