<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function ringkasan()
    {
        $bookingSaved = false;
        $error = '';
        $loggedIn = true; // dummy

        return view('booking.ringkasan', compact('bookingSaved', 'error', 'loggedIn'));
    }

    public function pesanan()
    {
        $error = '';
        $success = '';
        
        $pesananAktif = [
            [
                'id_booking' => 1,
                'tanggal_booking' => '2026-04-28',
                'nama_jasa' => 'Desain Logo',
                'nama_kategori' => 'Desain Grafis',
                'nama_klien' => 'Andi Wijaya',
                'no_telp_klien' => '08123456789',
                'alamat_booking' => 'Jl. Mawar No. 10',
                'catatan' => 'Buatkan logo minimalis',
                'status_booking' => 'MENUNGGU',
                'tarif' => 150000,
                'nama_satuan' => 'Proyek'
            ]
        ];

        $pesananSelesai = [
            [
                'id_booking' => 2,
                'tanggal_booking' => '2026-04-20',
                'nama_jasa' => 'Desain Banner',
                'nama_kategori' => 'Desain Grafis',
                'nama_klien' => 'Citra Kirana',
                'status_booking' => 'SELESAI',
                'rating' => 5,
                'komentar' => 'Bagus sekali!'
            ]
        ];

        return view('booking.pesanan', compact('pesananAktif', 'pesananSelesai', 'error', 'success'));
    }
}
