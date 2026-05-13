<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use App\Models\Jasa;
use App\Models\Satuan;
use App\Models\Layanan;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\PengajuanFreelancer;
use App\Models\Booking;

class FreelancerController extends Controller
{
    public function mulai()
    {
        return view('freelancer.mulai');
    }

    public function daftar()
    {
        $user = auth()->user();
        if ($user->id_role == 3) {
            return redirect()->route('freelancer.kelola');
        }

        $provinsiList = Provinsi::orderBy('nama_provinsi')->get();
        $kabupatenList = Kabupaten::orderBy('nama_kabupaten')->get();
        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();
        $desaList = Desa::orderBy('nama_desa')->get();

        $cekPengajuan = PengajuanFreelancer::where('id_pengguna', $user->id_pengguna)
            ->orderBy('tanggal_pengajuan', 'desc')->first();

        if ($cekPengajuan && $cekPengajuan->status == 'DITERIMA') {
            // Safety fallback just in case session/role not updated
            $user->update(['id_role' => 3]);
            return redirect()->route('freelancer.kelola');
        }

        return view('freelancer.daftar', compact(
            'provinsiList', 'kabupatenList', 'kecamatanList', 'desaList', 'cekPengajuan', 'user'
        ));
    }

    public function storePengajuan(Request $request)
    {
        $user = auth()->user();
        if ($user->id_role == 3) {
            return redirect()->route('freelancer.kelola');
        }

        $request->validate([
            'nik' => 'required|string|size:16',
            'deskripsi' => 'required|string',
            'id_provinsi' => 'required|integer',
            'id_kabupaten' => 'required|integer',
            'id_kecamatan' => 'required|integer',
            'id_desa' => 'required|integer',
            'alamat_lengkap' => 'required|string',
            'agree' => 'required',
        ], [
            'agree.required' => 'Anda harus menyetujui syarat & ketentuan.',
            'nik.size' => 'NIK harus 16 digit.'
        ]);

        try {
            DB::beginTransaction();

            $user->update([
                'id_provinsi' => $request->id_provinsi,
                'id_kabupaten' => $request->id_kabupaten,
                'id_kecamatan' => $request->id_kecamatan,
                'id_desa' => $request->id_desa,
                'alamat_lengkap' => $request->alamat_lengkap,
            ]);

            PengajuanFreelancer::create([
                'id_pengguna' => $user->id_pengguna,
                'nik' => $request->nik,
                'deskripsi' => $request->deskripsi,
                'status' => 'MENUNGGU'
            ]);

            DB::commit();

            return redirect()->back()->with('successMsg', 'Pengajuan dan pembaruan profil berhasil disimpan! Silakan tunggu admin memverifikasi pengajuan Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errorMsg', 'Terjadi kesalahan saat memproses data. Silakan coba lagi.');
        }
    }

    public function kelola()
    {
        $user = auth()->user();
        if ($user->id_role != 3) {
            return redirect()->route('home');
        }

        $kategoriList = Kategori::orderBy('nama_kategori')->get();
        $jasaList = Jasa::orderBy('nama_jasa')->get();
        $satuanList = Satuan::orderBy('nama_satuan')->get();

        $id_pengguna = $user->id_pengguna;

        $layanans = Layanan::with(['jasa.kategori', 'satuan'])->where('id_pengguna', $id_pengguna)->get();

        $myCategories = [];
        $grouped = [];

        foreach ($layanans as $layanan) {
            if (!$layanan->jasa || !$layanan->jasa->kategori) continue;
            
            $id_kategori = $layanan->jasa->kategori->id_kategori;
            if (!isset($grouped[$id_kategori])) {
                $grouped[$id_kategori] = [
                    'id_kategori' => $id_kategori,
                    'nama_kategori' => $layanan->jasa->kategori->nama_kategori,
                    'tarif' => $layanan->tarif,
                    'deskripsi' => $layanan->deskripsi,
                    'id_satuan' => $layanan->satuan ? $layanan->satuan->id_satuan : null,
                    'nama_satuan' => $layanan->satuan ? $layanan->satuan->nama_satuan : '-',
                    'jasa_names' => [],
                    'jasa_ids' => []
                ];
            }
            $grouped[$id_kategori]['jasa_names'][] = $layanan->jasa->nama_jasa;
            $grouped[$id_kategori]['jasa_ids'][] = (string)$layanan->jasa->id_jasa;
        }

        foreach ($grouped as $g) {
            $myCategories[] = [
                'id_kategori' => $g['id_kategori'],
                'nama_kategori' => $g['nama_kategori'],
                'tarif' => $g['tarif'],
                'deskripsi' => $g['deskripsi'],
                'id_satuan' => $g['id_satuan'],
                'nama_satuan' => $g['nama_satuan'],
                'jasa_names' => implode(', ', $g['jasa_names']),
                'jasa_ids_json' => json_encode($g['jasa_ids'])
            ];
        }

        $isFreelancer = !empty($myCategories);

        return view('freelancer.kelola', compact('kategoriList', 'jasaList', 'satuanList', 'myCategories', 'isFreelancer', 'user'));
    }

    public function storeLayanan(Request $request)
    {
        $user = auth()->user();
        if ($user->id_role != 3) {
            abort(403);
        }

        $action = $request->input('action');
        $id_kategori = $request->input('id_kategori');

        if ($action === 'save') {
            $request->validate([
                'id_kategori' => 'required',
                'tarif' => 'required|numeric',
                'jasa' => 'required|array|min:1',
            ], [
                'jasa.required' => 'Minimal satu jasa harus ditandai.'
            ]);

            $jasas = $request->input('jasa');
            $id_satuan = $request->input('id_satuan');
            $tarif = $request->input('tarif');
            $deskripsi = $request->input('deskripsi');

            try {
                DB::beginTransaction();

                $existingLayanans = Layanan::where('id_pengguna', $user->id_pengguna)
                    ->whereHas('jasa', function($q) use ($id_kategori) {
                        $q->where('id_kategori', $id_kategori);
                    })->get();
                
                $existingJasaIds = $existingLayanans->pluck('id_jasa')->toArray();
                $layananIds = $existingLayanans->pluck('id_layanan')->toArray();
                
                $toAdd = array_diff($jasas, $existingJasaIds);
                $toRemove = array_diff($existingJasaIds, $jasas);

                if (!empty($layananIds)) {
                    Layanan::whereIn('id_layanan', $layananIds)
                        ->update([
                            'tarif' => $tarif,
                            'deskripsi' => $deskripsi,
                            'id_satuan' => $id_satuan ?: null
                        ]);
                }

                foreach ($toAdd as $jasa_id) {
                    Layanan::create([
                        'id_pengguna' => $user->id_pengguna,
                        'id_jasa' => $jasa_id,
                        'id_satuan' => $id_satuan ?: null,
                        'tarif' => $tarif,
                        'deskripsi' => $deskripsi
                    ]);
                }

                foreach ($toRemove as $jasa_id) {
                    $hasBooking = Booking::whereHas('layanan', function($q) use ($user, $jasa_id) {
                        $q->where('id_pengguna', $user->id_pengguna)->where('id_jasa', $jasa_id);
                    })->exists();
                    
                    if ($hasBooking) {
                        throw new \Exception("Tidak dapat menghapus pilihan sub-jasa yang sudah pernah dipesan. (Centang kembali atau tambahkan yang lain)");
                    }
                    Layanan::where('id_pengguna', $user->id_pengguna)->where('id_jasa', $jasa_id)->delete();
                }

                DB::commit();
                return redirect()->back()->with('success', 'Layanan berhasil disimpan!');

            } catch (\Exception $e) {
                DB::rollBack();
                $msg = $e->getMessage();
                if (strpos($msg, 'Tidak dapat') === false) {
                    $msg = 'Terjadi kesalahan sistem saat menyimpan data layanan.';
                }
                return redirect()->back()->with('error', $msg);
            }
        } elseif ($action === 'delete') {
            try {
                DB::beginTransaction();

                $hasBooking = Booking::whereHas('layanan.jasa', function($q) use ($user, $id_kategori) {
                    $q->where('id_kategori', $id_kategori);
                })->whereHas('layanan', function($q) use ($user) {
                    $q->where('id_pengguna', $user->id_pengguna);
                })->exists();

                if ($hasBooking) {
                    throw new \Exception("Tidak dapat menghapus kategori yang memiliki riwayat pesanan (Cukup edit harganya saja).");
                }

                $layanansToDelete = Layanan::where('id_pengguna', $user->id_pengguna)
                    ->whereHas('jasa', function($q) use ($id_kategori) {
                        $q->where('id_kategori', $id_kategori);
                    })->pluck('id_layanan')->toArray();
                
                Layanan::whereIn('id_layanan', $layanansToDelete)->delete();

                $count = Layanan::where('id_pengguna', $user->id_pengguna)->count();
                if ($count == 0) {
                    $user->update(['id_role' => 2]);
                }

                DB::commit();
                
                if ($count == 0) {
                    return redirect()->route('home');
                }
                return redirect()->back()->with('success', 'Kategori layanan berhasil dihapus.');

            } catch (\Exception $e) {
                DB::rollBack();
                $msg = $e->getMessage();
                if (strpos($msg, 'Tidak dapat') === false) {
                    $msg = 'Gagal menghapus layanan.';
                }
                return redirect()->back()->with('error', $msg);
            }
        }
        
        return redirect()->back();
    }
}
