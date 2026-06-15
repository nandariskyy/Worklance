<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UlasanSeeder extends Seeder
{
    /**
     * Seed data dummy ulasan / review.
     */
    public function run(): void
    {
        DB::table('ulasan')->insert([
            ['id_ulasan' => 1, 'id_booking' => 3,  'id_pengguna' => 2, 'rating' => 5, 'komentar' => 'Sangat memuaskan!',          'tanggal_ulasan' => '2026-04-07'],
            ['id_ulasan' => 2, 'id_booking' => 4,  'id_pengguna' => 3, 'rating' => 4, 'komentar' => 'Bagus tapi agak lama',        'tanggal_ulasan' => '2026-04-08'],
            ['id_ulasan' => 3, 'id_booking' => 2,  'id_pengguna' => 3, 'rating' => 5, 'komentar' => 'Pelayanan cepat!',            'tanggal_ulasan' => '2026-04-06'],
            ['id_ulasan' => 4, 'id_booking' => 6,  'id_pengguna' => 8, 'rating' => 5, 'komentar' => 'Desainnya keren banget!',     'tanggal_ulasan' => '2026-04-10'],
            ['id_ulasan' => 5, 'id_booking' => 7,  'id_pengguna' => 9, 'rating' => 4, 'komentar' => 'Lumayan bagus',               'tanggal_ulasan' => '2026-04-11'],
            ['id_ulasan' => 6, 'id_booking' => 1,  'id_pengguna' => 4, 'rating' => 4, 'komentar' => 'Mantapp',                     'tanggal_ulasan' => '2026-05-13'],
            ['id_ulasan' => 7, 'id_booking' => 8,  'id_pengguna' => 2, 'rating' => 5, 'komentar' => 'Pekerjaan nya sangat rapi',   'tanggal_ulasan' => '2026-05-13'],
            ['id_ulasan' => 8, 'id_booking' => 13, 'id_pengguna' => 8, 'rating' => 5, 'komentar' => 'Pengajar sangat ramah',       'tanggal_ulasan' => '2026-06-10'],
        ]);
    }
}
