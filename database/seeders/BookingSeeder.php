<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Seed data dummy booking.
     */
    public function run(): void
    {
        DB::table('booking')->insert([
            ['id_booking' => 1,  'id_pengguna' => 2, 'id_layanan' => 1,  'tanggal_booking' => '2026-04-05', 'alamat_booking' => 'Surabaya',                              'catatan' => 'Butuh cepat',                             'status_booking' => 'SELESAI'],
            ['id_booking' => 2,  'id_pengguna' => 3, 'id_layanan' => 2,  'tanggal_booking' => '2026-04-06', 'alamat_booking' => 'Surabaya',                              'catatan' => 'Untuk usaha saya',                        'status_booking' => 'SELESAI'],
            ['id_booking' => 3,  'id_pengguna' => 2, 'id_layanan' => 3,  'tanggal_booking' => '2026-04-07', 'alamat_booking' => 'Surabaya',                              'catatan' => 'Elektronik rusak',                        'status_booking' => 'SELESAI'],
            ['id_booking' => 4,  'id_pengguna' => 3, 'id_layanan' => 5,  'tanggal_booking' => '2026-04-08', 'alamat_booking' => 'Surabaya',                              'catatan' => 'Prewedding',                              'status_booking' => 'SELESAI'],
            ['id_booking' => 5,  'id_pengguna' => 2, 'id_layanan' => 7,  'tanggal_booking' => '2026-04-09', 'alamat_booking' => 'Surabaya',                              'catatan' => 'Website toko online',                     'status_booking' => 'DIBATALKAN'],
            ['id_booking' => 6,  'id_pengguna' => 8, 'id_layanan' => 9,  'tanggal_booking' => '2026-04-10', 'alamat_booking' => 'Surabaya',                              'catatan' => 'Untuk bisnis online',                     'status_booking' => 'MENUNGGU'],
            ['id_booking' => 7,  'id_pengguna' => 9, 'id_layanan' => 10, 'tanggal_booking' => '2026-04-11', 'alamat_booking' => 'Malang',                                'catatan' => 'Butuh cepat',                             'status_booking' => 'DIPROSES'],
            ['id_booking' => 8,  'id_pengguna' => 2, 'id_layanan' => 11, 'tanggal_booking' => '2026-04-12', 'alamat_booking' => 'Sidoarjo',                              'catatan' => 'Untuk acara keluarga',                    'status_booking' => 'SELESAI'],
            ['id_booking' => 9,  'id_pengguna' => 2, 'id_layanan' => 1,  'tanggal_booking' => '2026-04-13', 'alamat_booking' => 'Jl. Cempaka putih, no 14, Sidoarjo',    'catatan' => 'Saya ingin logo untuk usaha UMKM saya',   'status_booking' => 'MENUNGGU'],
            ['id_booking' => 10, 'id_pengguna' => 2, 'id_layanan' => 4,  'tanggal_booking' => '2026-06-16', 'alamat_booking' => 'Surabaya, Rungkut Madya',               'catatan' => 'Ac di rumah saya rusak',                  'status_booking' => 'MENUNGGU'],
            ['id_booking' => 11, 'id_pengguna' => 2, 'id_layanan' => 5,  'tanggal_booking' => '2026-06-10', 'alamat_booking' => 'GRESIK',                                'catatan' => 'FOTO PREWEDDING DYA',                     'status_booking' => 'MENUNGGU'],
            ['id_booking' => 12, 'id_pengguna' => 8, 'id_layanan' => 12, 'tanggal_booking' => '2026-06-11', 'alamat_booking' => 'Sumput, Sidaorjo',                      'catatan' => 'MC untuk acara ulang tahun anak',         'status_booking' => 'DIBATALKAN'],
            ['id_booking' => 13, 'id_pengguna' => 8, 'id_layanan' => 24, 'tanggal_booking' => '2026-06-11', 'alamat_booking' => 'Sumput, Sidoarjo',                      'catatan' => 'Saya butuh les untuk anak saya',          'status_booking' => 'SELESAI'],
        ]);
    }
}
