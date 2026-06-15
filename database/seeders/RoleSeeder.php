<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Seed data master role pengguna.
     */
    public function run(): void
    {
        DB::table('role')->insert([
            ['id_role' => 1, 'nama_role' => 'Admin'],
            ['id_role' => 2, 'nama_role' => 'User'],
            ['id_role' => 3, 'nama_role' => 'Freelancer'],
        ]);
    }
}
