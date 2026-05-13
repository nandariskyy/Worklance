<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Booking;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function informasi()
    {
        $user = auth()->user();
        return view('pengaturan.informasi', compact('user'));
    }

    public function updateInformasi(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:pengguna,username,' . $user->id_pengguna . ',id_pengguna',
            'tanggal_lahir' => 'nullable|date'
        ], [
            'username.unique' => 'Username sudah digunakan.'
        ]);

        $user->update([
            'nama_pengguna' => $request->nama_pengguna,
            'username' => $request->username,
            'tanggal_lahir' => $request->tanggal_lahir
        ]);

        return redirect()->back()->with('success', 'Informasi akun berhasil diperbarui.');
    }

    public function kontak()
    {
        $user = auth()->user();
        
        $provinsiList = Provinsi::orderBy('nama_provinsi')->get();
        $kabupatenList = Kabupaten::orderBy('nama_kabupaten')->get();
        $kecamatanList = Kecamatan::orderBy('nama_kecamatan')->get();
        $desaList = Desa::orderBy('nama_desa')->get();

        return view('pengaturan.kontak', compact('user', 'provinsiList', 'kabupatenList', 'kecamatanList', 'desaList'));
    }

    public function updateKontak(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'email' => 'required|email|unique:pengguna,email,' . $user->id_pengguna . ',id_pengguna',
            'no_telp' => 'nullable|string|max:20',
            'id_provinsi' => 'nullable|integer',
            'id_kabupaten' => 'nullable|integer',
            'id_kecamatan' => 'nullable|integer',
            'id_desa' => 'nullable|integer',
            'alamat_lengkap' => 'nullable|string'
        ], [
            'email.unique' => 'Email sudah digunakan.'
        ]);

        $user->update([
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'id_provinsi' => $request->id_provinsi ?: null,
            'id_kabupaten' => $request->id_kabupaten ?: null,
            'id_kecamatan' => $request->id_kecamatan ?: null,
            'id_desa' => $request->id_desa ?: null,
            'alamat_lengkap' => $request->alamat_lengkap
        ]);

        return redirect()->back()->with('success', 'Kontak & alamat berhasil diperbarui.');
    }

    public function keamanan()
    {
        $user = auth()->user();
        return view('pengaturan.keamanan', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:3',
            'konfirmasi_password' => 'required|same:password_baru'
        ], [
            'konfirmasi_password.same' => 'Konfirmasi password tidak cocok.',
            'password_baru.min' => 'Password baru minimal 3 karakter.'
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

    public function hapusAkun(Request $request)
    {
        $request->validate([
            'konfirmasi_hapus' => 'required'
        ]);

        if ($request->konfirmasi_hapus !== 'HAPUS') {
            return redirect()->back()->with('error', 'Ketik "HAPUS" untuk mengonfirmasi penghapusan akun.');
        }

        $user = auth()->user();

        // Delete associated Layanan (which will be cascade deleted if setup, but safe to delete manually)
        Layanan::where('id_pengguna', $user->id_pengguna)->delete();
        
        // Delete User
        $user->delete();

        // Logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
