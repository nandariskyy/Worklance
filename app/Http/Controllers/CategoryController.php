<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Layanan;
use App\Models\Kabupaten;
use App\Models\Jasa;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function show(Request $request, $id)
    {
        // Ambil data kategori
        $kategori = Kategori::findOrFail($id);

        // Ambil filter yang dipilih
        $filterKota = $request->query('kota');
        $filterJasa = $request->query('jasa');

        // Data untuk dropdown filter
        $listKota = Kabupaten::orderBy('nama_kabupaten', 'asc')->get();
        $listJasa = Jasa::where('id_kategori', $id)->orderBy('nama_jasa', 'asc')->get();

        // Ambil semua layanan dalam kategori ini (dan kecualikan admin)
        $query = Layanan::with(['pengguna.kabupaten', 'jasa', 'satuan'])
            ->whereHas('pengguna', function($q) {
                $q->where('id_role', 3);
            })
            ->whereHas('jasa', function($q) use ($id, $filterJasa) {
                $q->where('jasa.id_kategori', $id);
                if (!empty($filterJasa)) {
                    $q->where('jasa.id_jasa', $filterJasa);
                }
            });

        // Filter berdasarkan kota
        if (!empty($filterKota)) {
            $query->whereHas('pengguna', function($q) use ($filterKota) {
                $q->where('pengguna.id_kabupaten', $filterKota);
            });
        }

        $layanans = $query->get();

        // Hitung rating & susun array untuk view
        $freelancers = [];
        foreach ($layanans as $layanan) {
            $avgRating = DB::table('ulasan')
                ->join('booking', 'ulasan.id_booking', '=', 'booking.id_booking')
                ->where('booking.id_layanan', $layanan->id_layanan)
                ->avg('ulasan.rating');

            // Ambil gambar cover atau portofolio pertama jika ada
            if ($layanan->gambar_cover) {
                $gambar_url = asset('storage/' . $layanan->gambar_cover);
            } else {
                $gambar_url = null;
            }

            $freelancers[] = [
                'id_layanan' => $layanan->id_layanan,
                'nama_pengguna' => $layanan->pengguna ? $layanan->pengguna->nama_pengguna : 'Tanpa Nama',
                'foto_profil' => $layanan->pengguna ? $layanan->pengguna->foto_profil : null,
                'alamat_lengkap' => $layanan->pengguna ? $layanan->pengguna->alamat_lengkap : '-',
                'nama_kota' => $layanan->pengguna && $layanan->pengguna->kabupaten ? $layanan->pengguna->kabupaten->nama_kabupaten : '-',
                'nama_jasa' => !empty($layanan->namajasa) ? $layanan->namajasa : ($layanan->jasa ? $layanan->jasa->nama_jasa : '-'),
                'namajasa_custom' => $layanan->namajasa ?? null,
                'deskripsi' => $layanan->deskripsi ?? '',
                'tarif' => $layanan->tarif ?? 0,
                'nama_satuan' => $layanan->satuan ? $layanan->satuan->nama_satuan : 'Pesanan',
                'avg_rating' => $avgRating ? round($avgRating, 1) : 0,
                'gambar' => $gambar_url
            ];
        }

        // Urutkan rating tertinggi
        usort($freelancers, function($a, $b) {
            return $b['avg_rating'] <=> $a['avg_rating'];
        });

        return view('kategori.show', compact('kategori', 'listKota', 'listJasa', 'freelancers', 'filterKota', 'filterJasa'));
    }
}
