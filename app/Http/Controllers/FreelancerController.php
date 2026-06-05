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
use App\Models\GambarPortofolio;
use Illuminate\Support\Facades\Storage;

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

        $layanans = Layanan::with(['jasa.kategori', 'satuan', 'gambarPortofolio'])->where('id_pengguna', $id_pengguna)->get();

        $myCategories = [];

        foreach ($layanans as $layanan) {

            if (!$layanan->jasa || !$layanan->jasa->kategori) {
                continue;
            }

            $myCategories[] = [
                'id_layanan' => $layanan->id_layanan,

                'id_kategori' => $layanan->jasa->kategori->id_kategori,
                'nama_kategori' => $layanan->jasa->kategori->nama_kategori,

                'id_jasa' => $layanan->id_jasa,
                'jasa_names' => $layanan->jasa->nama_jasa,

                'tarif' => $layanan->tarif,
                'namajasa' => $layanan->namajasa,
                'deskripsi' => $layanan->deskripsi,
                'gambar_cover' => $layanan->gambar_cover ? asset('storage/' . $layanan->gambar_cover) : null,

                'id_satuan' => optional($layanan->satuan)->id_satuan,
                'nama_satuan' => optional($layanan->satuan)->nama_satuan,

                'gambar' => $layanan->gambarPortofolio
                    ->map(function ($g) {
                        return [
                            'id_gambar'   => $g->id_gambar,
                            'file_gambar' => $g->file_gambar,
                        ];
                    })
                    ->toArray(),

                'jasa_ids_json' => json_encode([
                    (string)$layanan->id_jasa
                ])
            ];
        }


        $isFreelancer = !empty($myCategories);

        return view('freelancer.kelola', compact('kategoriList', 'jasaList', 'satuanList', 'myCategories', 'isFreelancer', 'user', 'layanans'));
    }

    public function profilFreelancer($id_layanan)
    {
        $layanan = Layanan::with(['jasa.kategori', 'satuan', 'pengguna.kabupaten'])
            ->findOrFail($id_layanan);

        $id_pengguna = $layanan->id_pengguna;

        $profileData = [
            'id_layanan'    => $layanan->id_layanan,
            'id_pengguna'   => $id_pengguna,
            'nama_jasa'     => !empty($layanan->namajasa) ? $layanan->namajasa : ($layanan->jasa->nama_jasa ?? '-'),
            'nama_pengguna' => $layanan->pengguna->nama_pengguna ?? '-',
            'foto_profil'   => $layanan->pengguna->foto_profil ?? null,
            'nama_kota'     => $layanan->pengguna->kabupaten->nama_kabupaten ?? '-',
            'no_telp'       => $layanan->pengguna->no_telp ?? '-',
            'alamat_lengkap'=> $layanan->pengguna->alamat_lengkap ?? '-',
            'tarif'         => $layanan->tarif,
            'nama_satuan'   => $layanan->satuan->nama_satuan ?? 'proyek',
            'deskripsi'     => $layanan->deskripsi ?? '',
            'nama_kategori' => $layanan->jasa->kategori->nama_kategori ?? '-',
        ];

        $jasaList = Layanan::with(['jasa', 'satuan'])
            ->where('id_pengguna', $id_pengguna)
            ->get()
            ->map(function($l) {
                $gambar = $l->gambar_cover ? asset('storage/' . $l->gambar_cover) : null;
                if (!$gambar) {
                    $gambarObj = \App\Models\GambarPortofolio::where('id_layanan', $l->id_layanan)->first();
                    $gambar = $gambarObj ? asset('storage/' . $gambarObj->file_gambar) : null;
                }
                
                return [
                    'id_layanan'  => $l->id_layanan,
                    'nama_jasa'   => !empty($l->namajasa) ? $l->namajasa : ($l->jasa->nama_jasa ?? '-'),
                    'tarif'       => $l->tarif,
                    'nama_satuan' => $l->satuan->nama_satuan ?? 'proyek',
                    'avg_rating'  => 5.0,
                    'gambar'      => $gambar,
                ];
            })->toArray();

       // GANTI bagian ulasan yang lama dengan ini:

        $ulasanRaw = DB::table('ulasan')
            ->join('booking', 'ulasan.id_booking', '=', 'booking.id_booking')
            ->join('layanan', 'booking.id_layanan', '=', 'layanan.id_layanan')
            ->join('pengguna', 'ulasan.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('layanan.id_pengguna', $id_pengguna)  // semua ulasan untuk freelancer ini
            ->select(
                'pengguna.nama_pengguna',
                'ulasan.rating',
                'ulasan.komentar',
                'ulasan.tanggal_ulasan'
            )
            ->orderBy('ulasan.tanggal_ulasan', 'desc')
            ->get();

        $ulasanList   = $ulasanRaw->map(fn($u) => (array) $u)->toArray();
        $total_ulasan = count($ulasanList);
        $avg_rating   = $total_ulasan > 0
            ? number_format($ulasanRaw->avg('rating'), 1)
            : '5.0';

        return view('layanan.profil_freelancer', compact(
            'profileData', 'jasaList', 'ulasanList', 'avg_rating', 'total_ulasan'
        ));
    }

    public function storeLayanan(Request $request)
    {
        $user = auth()->user();
        if ($user->id_role != 3) {
            abort(403);
        }

        $action = $request->input('action');
        $id_kategori = $request->input('id_kategori');
        $id_layanan = $request->input('id_layanan');

        if ($action === 'save') {
            // Perubahan: Validasi untuk single value (bukan array)
            $request->validate([
                'id_kategori' => 'required',
                'tarif' => 'required|numeric',
                'jasa' => 'required', 
                'namajasa' => 'required|string|max:255',// Tidak lagi array|min:1

                'portofolio_images' => 'nullable|array|max:5',
                'portofolio_images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
                'gambar_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ], [
                'jasa.required' => 'Jasa harus dipilih.',
                    'portofolio_images.required' => 'Minimal 1 gambar portofolio wajib diupload.',
                    'portofolio_images.min' => 'Minimal 1 gambar.',
                    'portofolio_images.max' => 'Maksimal 5 gambar.',
            ]);

            // Perubahan: Hanya dapat 1 nilai (bukan array)
            $id_jasa = $request->input('jasa');
            $id_layanan = $request->input('id_layanan');
            $id_satuan = $request->input('id_satuan');
            $tarif = $request->input('tarif');
            $deskripsi = $request->input('deskripsi');
            $namajasa = $request->input('namajasa');

            try {
                DB::beginTransaction();

                if ($id_layanan) {
                    $layanan = Layanan::where(
                        'id_layanan',
                        $id_layanan
                    )->where(
                        'id_pengguna',
                        $user->id_pengguna
                    )->firstOrFail();

                    $hasBooking = Booking::where(
                        'id_layanan',
                        $layanan->id_layanan
                    )->exists();

                    if ($hasBooking && $layanan->id_jasa != $id_jasa) {
                        throw new \Exception(
                            "Tidak dapat mengubah jasa karena sudah ada riwayat pesanan."
                        );
                    }

                    $updateData = [
                        'id_jasa' => $id_jasa,
                        'id_satuan' => $id_satuan ?: null,
                        'tarif' => $tarif,
                        'namajasa' => $namajasa,
                        'deskripsi' => $deskripsi
                    ];

                    if ($request->input('remove_cover') == '1') {
                        if ($layanan->gambar_cover) {
                            Storage::disk('public')->delete($layanan->gambar_cover);
                        }
                        $updateData['gambar_cover'] = null;
                    } elseif ($request->hasFile('gambar_cover')) {
                        if ($layanan->gambar_cover) {
                            Storage::disk('public')->delete($layanan->gambar_cover);
                        }
                        $updateData['gambar_cover'] = $request->file('gambar_cover')->store('covers', 'public');
                    }

                    $layanan->update($updateData);

                    if ($request->filled('deleted_images')) {

                        $deletedImages = json_decode(
                            $request->deleted_images,
                            true
                        );

                        foreach ($deletedImages as $idGambar) {

                            $gambar = GambarPortofolio::find($idGambar);

                            if ($gambar) {

                                Storage::disk('public')
                                    ->delete($gambar->file_gambar);

                                $gambar->delete();
                            }
                        }
                    }

                } else {

                    $createData = [
                        'id_pengguna' => $user->id_pengguna,
                        'id_jasa' => $id_jasa,
                        'id_satuan' => $id_satuan ?: null,
                        'tarif' => $tarif,
                        'namajasa' => $namajasa,
                        'deskripsi' => $deskripsi
                    ];

                    if ($request->hasFile('gambar_cover')) {
                        $createData['gambar_cover'] = $request->file('gambar_cover')->store('covers', 'public');
                    }

                    $layanan = Layanan::create($createData);

                }

                if ($request->hasFile('portofolio_images')) {

                    foreach ($request->file('portofolio_images') as $file) {

                        $filename = time() . '_' . uniqid() . '.' .
                                    $file->getClientOriginalExtension();

                        $file->storeAs(
                            'portofolio',
                            $filename,
                            'public'
                        );

                        GambarPortofolio::create([
                            'id_layanan' => $layanan->id_layanan,
                            'file_gambar' => 'portofolio/' . $filename
                        ]);
                    }
                }

                DB::commit();
                return redirect()->back()->with('success', 'Layanan berhasil disimpan!');

            } catch (\Exception $e) {
                DB::rollBack();
                $msg = $e->getMessage();
                
                return redirect()->back()->with('error', $msg);
            }

        } elseif ($action === 'delete') {
            // Logika delete tetap sama
            try {
                DB::beginTransaction();

                $layanan = Layanan::where(
                    'id_layanan',
                    $id_layanan
                )->where(
                    'id_pengguna',
                    $user->id_pengguna
                )->firstOrFail();

                $hasBooking = Booking::where(
                    'id_layanan',
                    $layanan->id_layanan
                )->exists();

                if ($hasBooking) {
                    throw new \Exception(
                        "Tidak dapat menghapus layanan yang memiliki riwayat pesanan."
                    );
                }

                $layanan->delete();

                $count = Layanan::where('id_pengguna', $user->id_pengguna)->count();
                if ($count == 0) {
                    $user->update(['id_role' => 2]);
                }

                DB::commit();
                
                if ($count == 0) {
                    return redirect()->route('home');
                }
                return redirect()->back()->with('success', 'Layanan berhasil dihapus.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
        
        return redirect()->back();
    }
}
