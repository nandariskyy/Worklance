<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengajuanFreelancerSeeder extends Seeder
{
    /**
     * Seed data dummy pengajuan freelancer.
     */
    public function run(): void
    {
        DB::table('pengajuan_freelancer')->insert([
            ['id_pengajuan' => 1, 'id_pengguna' => 2,  'nik' => '6301234567891111', 'deskripsi' => null,                                       'status' => 'DITERIMA',  'catatan_admin' => null,                 'tanggal_pengajuan' => '2026-04-03 14:39:24'],
            ['id_pengajuan' => 2, 'id_pengguna' => 3,  'nik' => '6301234567892222', 'deskripsi' => null,                                       'status' => 'DITOLAK',   'catatan_admin' => 'Data kurang lengkap', 'tanggal_pengajuan' => '2026-04-03 14:39:24'],
            ['id_pengajuan' => 3, 'id_pengguna' => 8,  'nik' => '6301234567893333', 'deskripsi' => null,                                       'status' => 'MENUNGGU',  'catatan_admin' => null,                 'tanggal_pengajuan' => '2026-04-03 21:30:10'],
            ['id_pengajuan' => 4, 'id_pengguna' => 9,  'nik' => '6301234567894444', 'deskripsi' => null,                                       'status' => 'DITERIMA',  'catatan_admin' => 'Data valid',         'tanggal_pengajuan' => '2026-04-03 21:30:10'],
            ['id_pengajuan' => 5, 'id_pengguna' => 3,  'nik' => '1111111111111111', 'deskripsi' => 'tess',                                     'status' => 'DITOLAK',   'catatan_admin' => 'NIK tidak valid',    'tanggal_pengajuan' => '2026-04-03 21:59:55'],
            ['id_pengajuan' => 6, 'id_pengguna' => 12, 'nik' => '1234567891234567', 'deskripsi' => 'Saya adalah pengisi acara',                'status' => 'DITERIMA',  'catatan_admin' => null,                 'tanggal_pengajuan' => '2026-06-14 09:38:22'],
            ['id_pengajuan' => 7, 'id_pengguna' => 12, 'nik' => '1234567891234567', 'deskripsi' => 'Saya adalah lulusan SMK jurusan Tata Boga', 'status' => 'MENUNGGU',  'catatan_admin' => null,                 'tanggal_pengajuan' => '2026-06-14 09:38:56'],
            ['id_pengajuan' => 8, 'id_pengguna' => 12, 'nik' => '1234567891234567', 'deskripsi' => 'Saya adalah lulusan SMK jurusan Tata Boga', 'status' => 'MENUNGGU',  'catatan_admin' => null,                 'tanggal_pengajuan' => '2026-06-14 09:39:27'],
        ]);
    }
}
