<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show($id)
    {
        $profileData = [
            'id_pengguna' => 1,
            'nama_pengguna' => 'Budi Santoso',
            'no_telp' => '08123456789',
            'alamat_lengkap' => 'Jl. Merdeka No.1, Jakarta',
            'email' => 'budi@example.com',
            'nama_kategori' => 'Desain Grafis',
            'id_kategori' => 1,
            'nama_satuan' => 'proyek',
            'tarif' => 150000,
            'deskripsi' => 'Saya adalah desainer grafis profesional dengan pengalaman 5 tahun. Siap membantu membuat logo, banner, dan kebutuhan desain lainnya dengan cepat dan hasil memuaskan.'
        ];

        $offeredJasaList = [
            ['id_layanan' => 1, 'nama_jasa' => 'Desain Logo'],
            ['id_layanan' => 2, 'nama_jasa' => 'Desain Banner'],
        ];

        $ulasanList = [
            [
                'rating' => 5,
                'komentar' => 'Hasil desain logo sangat memuaskan dan cepat! Revisi juga dilayani dengan baik.',
                'tanggal_ulasan' => '2026-04-10',
                'nama_pengguna' => 'Andi Wijaya'
            ],
            [
                'rating' => 4,
                'komentar' => 'Bagus, tapi warnanya kurang pas awalnya. Setelah revisi jadi lebih baik.',
                'tanggal_ulasan' => '2026-04-12',
                'nama_pengguna' => 'Citra Kirana'
            ],
        ];

        $total_ulasan = 2;
        $avg_rating = 4.5;

        return view('layanan.show', compact('profileData', 'offeredJasaList', 'ulasanList', 'total_ulasan', 'avg_rating'));
    }
}
