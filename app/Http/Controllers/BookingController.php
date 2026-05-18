<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Ulasan;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function ringkasan()
    {
        $loggedIn = auth()->check();
        return view('booking.ringkasan', compact('loggedIn'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_layanan' => 'required|integer',
            'tanggal_booking' => 'required|date',
            'alamat_booking' => 'required|string',
        ]);

        try {
            $booking = Booking::create([
                'id_pengguna' => auth()->id(),
                'id_layanan' => $request->id_layanan,
                'tanggal_booking' => $request->tanggal_booking,
                'alamat_booking' => $request->alamat_booking,
                'catatan' => $request->catatan,
                'status_booking' => 'MENUNGGU'
            ]);

            return redirect()->back()->with('success', 'Booking berhasil!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan pesanan. Silakan coba lagi.');
        }
    }

    public function pesanan()
    {
        $user = auth()->user();

        // Ambil pesanan SEBAGAI FREELANCER (masuk ke layanan miliknya)
        $bookingsMasuk = Booking::with(['layanan.jasa.kategori', 'layanan.satuan', 'pengguna', 'ulasan'])
            ->whereHas('layanan', function($q) use ($user) {
                $q->where('id_pengguna', $user->id_pengguna);
            })->orderBy('tanggal_booking', 'desc')->get();

        $pesananAktif = [];
        $pesananSelesai = [];

        // Format Pesanan Masuk (Sebagai Freelancer)
        foreach ($bookingsMasuk as $booking) {
            $data = $this->formatBookingData($booking, true);
            if (in_array($booking->status_booking, ['SELESAI', 'DIBATALKAN', 'DITOLAK'])) {
                $pesananSelesai[] = $data;
            } else {
                $pesananAktif[] = $data;
            }
        }

        return view('booking.pesanan', compact(
            'pesananAktif', 'pesananSelesai', 'user'
        ));
    }

    public function riwayat()
    {
        $user = auth()->user();

        // Ambil pesanan SEBAGAI KLIEN (yang dia buat)
        $bookingsDibuat = Booking::with(['layanan.jasa.kategori', 'layanan.satuan', 'layanan.pengguna', 'ulasan'])
            ->where('id_pengguna', $user->id_pengguna)
            ->orderBy('tanggal_booking', 'desc')->get();

        $klienAktif = [];
        $klienSelesai = [];

        // Format Pesanan Keluar (Sebagai Klien)
        foreach ($bookingsDibuat as $booking) {
            $data = $this->formatBookingData($booking, false);
            if (in_array($booking->status_booking, ['SELESAI', 'DIBATALKAN', 'DITOLAK'])) {
                $klienSelesai[] = $data;
            } else {
                $klienAktif[] = $data;
            }
        }

        return view('booking.riwayat', compact(
            'klienAktif', 'klienSelesai', 'user'
        ));
    }

    private function formatBookingData($booking, $isFreelancer)
    {
        $data = [
            'id_booking' => $booking->id_booking,
            'tanggal_booking' => $booking->tanggal_booking,
            'nama_jasa' => $booking->layanan && $booking->layanan->jasa ? $booking->layanan->jasa->nama_jasa : '-',
            'nama_kategori' => $booking->layanan && $booking->layanan->jasa && $booking->layanan->jasa->kategori ? $booking->layanan->jasa->kategori->nama_kategori : '-',
            'alamat_booking' => $booking->alamat_booking,
            'catatan' => $booking->catatan,
            'status_booking' => $booking->status_booking,
            'tarif' => $booking->layanan ? $booking->layanan->tarif : 0,
            'nama_satuan' => $booking->layanan && $booking->layanan->satuan ? $booking->layanan->satuan->nama_satuan : '-'
        ];

        if ($isFreelancer) {
            $data['nama_klien'] = $booking->pengguna ? $booking->pengguna->nama_pengguna : '-';
            $data['no_telp_klien'] = $booking->pengguna ? $booking->pengguna->no_telp : '-';
        } else {
            $data['nama_freelancer'] = $booking->layanan && $booking->layanan->pengguna ? $booking->layanan->pengguna->nama_pengguna : '-';
            $data['no_telp_freelancer'] = $booking->layanan && $booking->layanan->pengguna ? $booking->layanan->pengguna->no_telp : '-';
        }

        if ($booking->status_booking == 'SELESAI') {
            $data['rating'] = $booking->ulasan ? $booking->ulasan->rating : null;
            $data['komentar'] = $booking->ulasan ? $booking->ulasan->komentar : null;
        }

        return $data;
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id_booking' => 'required',
            'status' => 'required|in:DIPROSES,SELESAI,DITOLAK,DIBATALKAN'
        ]);

        $booking = Booking::with('layanan')->findOrFail($request->id_booking);
        $user = auth()->user();

        // Jika mengubah status menjadi DITOLAK atau DIPROSES atau SELESAI, itu tugas freelancer
        if (in_array($request->status, ['DIPROSES', 'DITOLAK', 'SELESAI'])) {
            if ($booking->layanan->id_pengguna != $user->id_pengguna) {
                abort(403);
            }
        }
        
        // Jika mengubah status menjadi DIBATALKAN, itu tugas klien
        if ($request->status == 'DIBATALKAN') {
            if ($booking->id_pengguna != $user->id_pengguna) {
                abort(403);
            }
        }

        $booking->update(['status_booking' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function storeUlasan(Request $request)
    {
        $request->validate([
            'id_booking' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string'
        ]);

        $booking = Booking::findOrFail($request->id_booking);

        // Hanya klien yang bisa memberi ulasan
        if ($booking->id_pengguna != auth()->id() || $booking->status_booking != 'SELESAI') {
            abort(403);
        }

        // Cek apakah sudah diulas
        if (Ulasan::where('id_booking', $booking->id_booking)->exists()) {
            return redirect()->back()->with('error', 'Pesanan ini sudah Anda ulas.');
        }

        Ulasan::create([
            'id_booking' => $booking->id_booking,
            'id_pengguna' => auth()->id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'tanggal_ulasan' => now()->toDateString()
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
