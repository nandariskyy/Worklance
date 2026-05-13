<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Jasa;
use App\Models\Layanan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data kategori
        $kategoriList = Kategori::all();

        // 2. Ambil data jasa dan dikelompokkan per kategori
        // Di views/home.blade.php diekspektasikan berupa array dengan key id_kategori
        $semuaJasa = Jasa::all();
        $jasaPerKategori = [];
        foreach ($semuaJasa as $jasa) {
            $jasaPerKategori[$jasa->id_kategori][] = $jasa;
        }

        // 3. Ambil freelancer unggulan (Layanan yang ada ratingnya)
        // Karena rating ada di ulasan -> booking -> layanan
        // Untuk saat ini kita ambil semua layanan dengan informasi avg_rating jika ada
        $layanans = Layanan::with(['pengguna', 'jasa.kategori'])
            ->get();
            
        $freelancerUnggulan = [];
        foreach ($layanans as $layanan) {
            // Hitung rata-rata rating
            $avgRating = DB::table('ulasan')
                ->join('booking', 'ulasan.id_booking', '=', 'booking.id_booking')
                ->where('booking.id_layanan', $layanan->id_layanan)
                ->avg('ulasan.rating');
                
            $freelancerUnggulan[] = [
                'id_layanan' => $layanan->id_layanan,
                'nama_pengguna' => $layanan->pengguna ? $layanan->pengguna->nama_pengguna : 'Tanpa Nama',
                'alamat_lengkap' => $layanan->pengguna ? $layanan->pengguna->alamat_lengkap : '-',
                'nama_kategori' => $layanan->jasa && $layanan->jasa->kategori ? $layanan->jasa->kategori->nama_kategori : '-',
                'nama_jasa' => $layanan->jasa ? $layanan->jasa->nama_jasa : '-',
                'avg_rating' => $avgRating ? round($avgRating, 1) : 0
            ];
        }

        // Urutkan berdasarkan rating terbaik (descending) dan ambil maksimal 4
        usort($freelancerUnggulan, function($a, $b) {
            return $b['avg_rating'] <=> $a['avg_rating'];
        });
        $freelancerUnggulan = array_slice($freelancerUnggulan, 0, 4);

        // 4. Kategori Icons (Tetap statis karena icon SVG lebih mudah disimpan di controller atau config)
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

        // 5. Pencarian
        $search = $request->query('search', '');
        $hasilCari = [];

        if ($search !== '') {
            $hasilCari = array_filter($freelancerUnggulan, function($fl) use ($search) {
                return stripos($fl['nama_pengguna'], $search) !== false || 
                       stripos($fl['nama_jasa'], $search) !== false || 
                       stripos($fl['nama_kategori'], $search) !== false;
            });
        }

        return view('home', compact('kategoriList', 'jasaPerKategori', 'freelancerUnggulan', 'kategoriIcons', 'search', 'hasilCari'));
    }
}
