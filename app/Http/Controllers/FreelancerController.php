<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    public function mulai()
    {
        return view('freelancer.mulai');
    }

    public function daftar()
    {
        return view('freelancer.daftar');
    }

    public function kelola()
    {
        $kategoriList = [
            ['id_kategori' => 1, 'nama_kategori' => 'Desain Grafis'],
            ['id_kategori' => 2, 'nama_kategori' => 'Teknisi Elektronik'],
        ];

        $jasaList = [
            ['id_jasa' => 1, 'nama_jasa' => 'Desain Logo', 'id_kategori' => 1],
            ['id_jasa' => 2, 'nama_jasa' => 'Desain Banner', 'id_kategori' => 1],
            ['id_jasa' => 3, 'nama_jasa' => 'Service AC', 'id_kategori' => 2],
        ];

        $satuanList = [
            ['id_satuan' => 1, 'nama_satuan' => 'Proyek'],
            ['id_satuan' => 2, 'nama_satuan' => 'Jam'],
        ];

        $myCategories = [
            [
                'id_kategori' => 1,
                'nama_kategori' => 'Desain Grafis',
                'tarif' => 150000,
                'deskripsi' => 'Melayani berbagai desain.',
                'id_satuan' => 1,
                'nama_satuan' => 'Proyek',
                'jasa_names' => 'Desain Logo, Desain Banner',
                'jasa_ids_json' => json_encode(["1", "2"])
            ]
        ];

        $isFreelancer = true;
        $success = '';
        $error = '';

        return view('freelancer.kelola', compact('kategoriList', 'jasaList', 'satuanList', 'myCategories', 'isFreelancer', 'success', 'error'));
    }
}
