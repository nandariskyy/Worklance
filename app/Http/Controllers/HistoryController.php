<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = [
            [
                'id' => '12345678',
                'title' => 'Desain Logo',
                'date' => '30 Mei 2024',
                'item' => 1,
                'status' => 'Menunggu',
                'total' => 200000,
                'image' => 'https://picsum.photos/200'
            ]
        ];

        return view('history.riwayat', compact('histories'));
    }
}