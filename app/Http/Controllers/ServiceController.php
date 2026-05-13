<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function show($id)
    {
        $layanan = Layanan::with(['pengguna', 'jasa.kategori', 'satuan'])->findOrFail($id);

        $profileData = [
            'id_pengguna' => $layanan->id_pengguna,
            'nama_pengguna' => $layanan->pengguna ? $layanan->pengguna->nama_pengguna : '-',
            'no_telp' => $layanan->pengguna ? $layanan->pengguna->no_telp : '-',
            'alamat_lengkap' => $layanan->pengguna ? $layanan->pengguna->alamat_lengkap : '-',
            'email' => $layanan->pengguna ? $layanan->pengguna->email : '-',
            'nama_kategori' => $layanan->jasa && $layanan->jasa->kategori ? $layanan->jasa->kategori->nama_kategori : '-',
            'id_kategori' => $layanan->jasa ? $layanan->jasa->id_kategori : null,
            'nama_satuan' => $layanan->satuan ? $layanan->satuan->nama_satuan : '-',
            'tarif' => $layanan->tarif,
            'deskripsi' => $layanan->deskripsi,
            'id_layanan' => $layanan->id_layanan,
            'nama_jasa' => $layanan->jasa ? $layanan->jasa->nama_jasa : '-'
        ];

        // Offered Jasa List (Jasa lain yang ditawarkan oleh user yang sama)
        $offeredJasaListQuery = Layanan::with('jasa')->where('id_pengguna', $layanan->id_pengguna)->get();
        $offeredJasaList = [];
        foreach ($offeredJasaListQuery as $oj) {
            $offeredJasaList[] = [
                'id_layanan' => $oj->id_layanan,
                'nama_jasa' => $oj->jasa ? $oj->jasa->nama_jasa : '-'
            ];
        }

        // Ulasan List
        $ulasans = DB::table('ulasan')
            ->join('booking', 'ulasan.id_booking', '=', 'booking.id_booking')
            ->join('pengguna', 'ulasan.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('booking.id_layanan', $id)
            ->select('ulasan.rating', 'ulasan.komentar', 'ulasan.tanggal_ulasan', 'pengguna.nama_pengguna')
            ->get();

        $ulasanList = [];
        $totalRating = 0;
        foreach ($ulasans as $u) {
            $ulasanList[] = [
                'rating' => $u->rating,
                'komentar' => $u->komentar,
                'tanggal_ulasan' => $u->tanggal_ulasan,
                'nama_pengguna' => $u->nama_pengguna
            ];
            $totalRating += $u->rating;
        }

        $total_ulasan = count($ulasanList);
        $avg_rating = $total_ulasan > 0 ? round($totalRating / $total_ulasan, 1) : 0;

        return view('layanan.show', compact('profileData', 'offeredJasaList', 'ulasanList', 'total_ulasan', 'avg_rating'));
    }
}
