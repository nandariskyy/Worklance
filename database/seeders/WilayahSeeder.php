<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    /**
     * Seed data wilayah Indonesia dari file SQL terpisah.
     * Data ini tidak dikonversi ke array PHP karena volumenya besar.
     */
    public function run(): void
    {
        $path = database_path('sql/wilayah.sql');

        if (file_exists($path)) {
            DB::unprepared(file_get_contents($path));
            $this->command->info('Data wilayah berhasil di-seed dari wilayah.sql');
        } else {
            $this->command->error('File wilayah.sql tidak ditemukan di database/sql/');
        }
    }
}
