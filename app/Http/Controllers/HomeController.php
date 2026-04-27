<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Dummy Data untuk tahap 1 (Frontend Layouting)
        $kategoriList = [
            ['id_kategori' => 1, 'nama_kategori' => 'Desain & Kreatif'],
            ['id_kategori' => 2, 'nama_kategori' => 'Teknisi & Perbaikan'],
            ['id_kategori' => 3, 'nama_kategori' => 'Fotografi & Videografi'],
            ['id_kategori' => 4, 'nama_kategori' => 'Pendidikan & Les Privat'],
            ['id_kategori' => 5, 'nama_kategori' => 'IT & Digital'],
            ['id_kategori' => 6, 'nama_kategori' => 'Rumah Tangga'],
            ['id_kategori' => 7, 'nama_kategori' => 'Tukang & Konstruksi'],
            ['id_kategori' => 8, 'nama_kategori' => 'Event & Hiburan'],
        ];

        $jasaPerKategori = [
            1 => [
                ['id_jasa' => 1, 'nama_jasa' => 'Desain Logo'],
                ['id_jasa' => 2, 'nama_jasa' => 'Desain Poster / Banner'],
                ['id_jasa' => 3, 'nama_jasa' => 'Desain Konten Sosial Media'],
                ['id_jasa' => 4, 'nama_jasa' => 'Editing Foto'],
                ['id_jasa' => 5, 'nama_jasa' => 'Editing Video Sederhana'],
            ],
            2 => [
                ['id_jasa' => 6, 'nama_jasa' => 'Service Alat Elektronik'],
                ['id_jasa' => 7, 'nama_jasa' => 'Service AC'],
                ['id_jasa' => 8, 'nama_jasa' => 'Kelistrikan Rumah'],
            ],
            3 => [
                ['id_jasa' => 9, 'nama_jasa' => 'Foto Prewedding'],
                ['id_jasa' => 10, 'nama_jasa' => 'Dokumentasi Acara'],
                ['id_jasa' => 11, 'nama_jasa' => 'Foto Produk UMKM'],
                ['id_jasa' => 12, 'nama_jasa' => 'Video Shooting Event'],
            ],
            4 => [
                ['id_jasa' => 13, 'nama_jasa' => 'Les Matematika'],
                ['id_jasa' => 14, 'nama_jasa' => 'Les Bahasa Inggris'],
                ['id_jasa' => 15, 'nama_jasa' => 'Les SD/SMP/SMA'],
                ['id_jasa' => 16, 'nama_jasa' => 'Les Mengaji'],
            ],
            5 => [
                ['id_jasa' => 17, 'nama_jasa' => 'Pembuatan Website'],
                ['id_jasa' => 18, 'nama_jasa' => 'Pembuatan Aplikasi Desktop'],
                ['id_jasa' => 19, 'nama_jasa' => 'Pembuatan Aplikasi Mobile'],
                ['id_jasa' => 20, 'nama_jasa' => 'UI/UX Design'],
            ],
            6 => [
                ['id_jasa' => 21, 'nama_jasa' => 'Bersih Rumah'],
                ['id_jasa' => 22, 'nama_jasa' => 'Cuci Setrika'],
            ],
            7 => [
                ['id_jasa' => 23, 'nama_jasa' => 'Tukang Bangunan'],
                ['id_jasa' => 24, 'nama_jasa' => 'Tukang Cat Rumah'],
                ['id_jasa' => 25, 'nama_jasa' => 'Tukang Kayu'],
                ['id_jasa' => 26, 'nama_jasa' => 'Renovasi Kecil'],
            ],
            8 => [
                ['id_jasa' => 27, 'nama_jasa' => 'MC Acara'],
                ['id_jasa' => 28, 'nama_jasa' => 'Penyanyi / Band'],
                ['id_jasa' => 29, 'nama_jasa' => 'Dekorasi Acara'],
                ['id_jasa' => 30, 'nama_jasa' => 'Wedding Organizer'],
            ],
        ];

        $freelancerUnggulan = [
            [
                'id_layanan' => 1, 'nama_pengguna' => 'Budi Santoso', 'alamat_lengkap' => 'Jl. Merdeka No.1',
                'nama_kategori' => 'Desain & Kreatif', 'nama_jasa' => 'Desain Logo', 'avg_rating' => 4.8
            ],
            [
                'id_layanan' => 2, 'nama_pengguna' => 'Siti Aminah', 'alamat_lengkap' => 'Jl. Sudirman No.2',
                'nama_kategori' => 'Fotografi & Videografi', 'nama_jasa' => 'Foto Prewedding', 'avg_rating' => 5.0
            ],
            [
                'id_layanan' => 3, 'nama_pengguna' => 'Agus Tukang', 'alamat_lengkap' => 'Jl. Pahlawan No.3',
                'nama_kategori' => 'Tukang & Konstruksi', 'nama_jasa' => 'Renovasi Kecil', 'avg_rating' => 4.6
            ],
            [
                'id_layanan' => 4, 'nama_pengguna' => 'Dedi Teknisi', 'alamat_lengkap' => 'Jl. Diponegoro No.4',
                'nama_kategori' => 'Teknisi & Perbaikan', 'nama_jasa' => 'Service AC', 'avg_rating' => 4.9
            ],
        ];

        $kategoriIcons = [
            1 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>',
            2 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>',
            3 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>',
            4 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>',
            5 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
            6 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>',
            7 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>',
            8 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>',
        ];

        $search = $request->query('search', '');
        $hasilCari = [];

        if ($search !== '') {
            // Mock search result
            $hasilCari = array_filter($freelancerUnggulan, function($fl) use ($search) {
                return stripos($fl['nama_pengguna'], $search) !== false || 
                       stripos($fl['nama_jasa'], $search) !== false || 
                       stripos($fl['nama_kategori'], $search) !== false;
            });
        }

        return view('home', compact('kategoriList', 'jasaPerKategori', 'freelancerUnggulan', 'kategoriIcons', 'search', 'hasilCari'));
    }
}
