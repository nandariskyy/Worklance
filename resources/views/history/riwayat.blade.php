@extends('layouts.app')

@section('title', 'Riwayat Pemesanan')

<br>

@section('content')

<div class="flex gap-6 mb-8 text-sm font-medium">

    <a href="/history?status=semua"
       class="pb-2 border-b-2 transition
       {{ ($status ?? 'semua') == 'semua' ? 'border-[#1D2555] text-[#1D2555]' : 'border-transparent text-gray-500 hover:text-[#1D2555]' }}">
        Semua
    </a>

    <a href="/history?status=menunggu"
       class="pb-2 border-b-2 transition
       {{ ($status ?? '') == 'menunggu' ? 'border-[#1D2555] text-[#1D2555]' : 'border-transparent text-gray-500 hover:text-[#1D2555]' }}">
        Menunggu
    </a>

    <a href="/history?status=diproses"
       class="pb-2 border-b-2 transition
       {{ ($status ?? '') == 'diproses' ? 'border-[#1D2555] text-[#1D2555]' : 'border-transparent text-gray-500 hover:text-[#1D2555]' }}">
        Diproses
    </a>

    <a href="/history?status=selesai"
       class="pb-2 border-b-2 transition
       {{ ($status ?? '') == 'selesai' ? 'border-[#1D2555] text-[#1D2555]' : 'border-transparent text-gray-500 hover:text-[#1D2555]' }}">
        Selesai
    </a>

    <a href="/history?status=dibatalkan"
       class="pb-2 border-b-2 transition
       {{ ($status ?? '') == 'dibatalkan' ? 'border-[#1D2555] text-[#1D2555]' : 'border-transparent text-gray-500 hover:text-[#1D2555]' }}">
        Dibatalkan
    </a>

</div>

<div class="max-w-7xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold text-[#1D2555] mb-10">
        Riwayat Pemesanan
    </h1>

    @if(empty($histories))
        <div class="text-center text-gray-500 py-20">
            <i class="fa-solid fa-box-open text-5xl mb-4"></i>
            <p class="text-lg">Belum ada riwayat pemesanan</p>
        </div>
    @else

        @foreach($histories as $history)

        <div class="bg-white rounded-3xl shadow-sm p-6 mb-6 border-l-[8px] border-[#1D2555]">

            <div class="flex justify-between items-center flex-wrap gap-6">

                <!-- LEFT -->
                <div class="flex gap-5">

                    <img
                        src="{{ $history['image'] }}"
                        class="w-32 h-32 rounded-2xl object-cover"
                    >

                    <div>
                        <p class="text-gray-500 mb-2">
                            #{{ $history['id'] }}
                        </p>

                        <h2 class="text-3xl font-bold text-[#1D2555] mb-3">
                            {{ $history['title'] }}
                        </h2>

                        <p class="text-gray-500 mb-4">
                            {{ $history['date'] }}
                        </p>

                        <span class="border px-4 py-2 rounded-full text-sm text-gray-500">
                            {{ $history['item'] }} Item
                        </span>
                    </div>

                </div>

                <!-- RIGHT -->
                <div class="text-right">

                    <span class="bg-[#1D2555] text-white px-5 py-2 rounded-full font-semibold">
                        {{ $history['status'] }}
                    </span>

                    <div class="mt-10">

                        <p class="text-gray-500">
                            Total {{ $history['item'] }} Produk
                        </p>

                        <h3 class="text-3xl font-bold text-[#1D2555]">
                            Rp{{ number_format($history['total'], 0, ',', '.') }}
                        </h3>

                    </div>

                </div>

            </div>

        </div>

        @endforeach

    @endif

</div>

@endsection