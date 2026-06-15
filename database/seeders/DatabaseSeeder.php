<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Urutan pemanggilan seeder disesuaikan dengan dependensi foreign key:
     *
     * --- Data Master ---
     * 1. Role              → tidak ada dependensi
     * 2. Kategori           → tidak ada dependensi
     * 3. Satuan             → tidak ada dependensi
     * 4. Jasa               → bergantung pada Kategori
     * 5. Wilayah (SQL)      → provinsi → kabupaten → kecamatan → desa
     *
     * --- Data Pengguna ---
     * 6. Admin              → bergantung pada Role & Wilayah (desa)
     * 7. Pengguna (dummy)   → bergantung pada Role & Wilayah (desa)
     *
     * --- Data Transaksi (dummy) ---
     * 8. Layanan            → bergantung pada Pengguna, Jasa, Satuan
     * 9. PengajuanFreelancer → bergantung pada Pengguna
     * 10. Booking           → bergantung pada Pengguna, Layanan
     * 11. Ulasan            → bergantung pada Booking, Pengguna
     */
    public function run(): void
    {
        $this->call([
            // Data master
            RoleSeeder::class,
            KategoriSeeder::class,
            SatuanSeeder::class,
            JasaSeeder::class,
            WilayahSeeder::class,

            // Data pengguna
            AdminSeeder::class,
            PenggunaSeeder::class,

            // Data transaksi (dummy)
            LayananSeeder::class,
            PengajuanFreelancerSeeder::class,
            BookingSeeder::class,
            UlasanSeeder::class,
        ]);
    }
}
