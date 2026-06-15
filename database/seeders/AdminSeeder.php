<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed akun admin default.
     */
    public function run(): void
    {
        DB::table('pengguna')->insert([
            'id_pengguna'    => 1,
            'id_role'        => 1,
            'username'       => 'admin',
            'nama_pengguna'  => 'Admin Worklance',
            'tanggal_lahir'  => '2000-05-10',
            'no_telp'        => '0821482734723',
            'email'          => 'admin@gmail.com',
            'password'       => Hash::make('123'),
            'id_provinsi'    => null,
            'id_kabupaten'   => null,
            'id_kecamatan'   => null,
            'id_desa'        => 1,
            'alamat_lengkap' => 'Surabaya',
            'foto_profil'    => null,
        ]);
    }
}
