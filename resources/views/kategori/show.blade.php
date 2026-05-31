@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Kategori -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-dark mb-3">Kategori: {{ $kategori->nama_kategori }}</h1>
            <p class="text-gray-500 text-lg">Temukan profesional terbaik untuk kebutuhan {{ strtolower($kategori->nama_kategori) }} Anda.</p>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-10">
            <form method="GET" action="{{ route('kategori.show', $kategori->id_kategori) }}" class="flex flex-col md:flex-row gap-4 items-end">
                
                <!-- Filter Kota -->
                <div class="flex-1 w-full">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Kota / Kabupaten</label>
                    <select name="kota" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors">
                        <option value="">Semua Kota</option>
                        @foreach($listKota as $kota)
                            <option value="{{ $kota->id_kabupaten }}" {{ $filterKota == $kota->id_kabupaten ? 'selected' : '' }}>
                                {{ $kota->nama_kabupaten }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filter Jasa -->
                <div class="flex-1 w-full">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Spesialisasi Jasa</label>
                    <select name="jasa" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors">
                        <option value="">Semua Spesialisasi</option>
                        @foreach($listJasa as $jasa)
                            <option value="{{ $jasa->id_jasa }}" {{ $filterJasa == $jasa->id_jasa ? 'selected' : '' }}>
                                {{ $jasa->nama_jasa }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Tombol Submit -->
                <div class="w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto bg-dark hover:bg-blue-900 text-white px-8 py-3 rounded-xl font-bold transition-colors shadow-md">
                        Terapkan Filter
                    </button>
                </div>
                
                @if(!empty($filterKota) || !empty($filterJasa))
                <div class="w-full md:w-auto mt-2 md:mt-0">
                    <a href="{{ route('kategori.show', $kategori->id_kategori) }}" class="block text-center w-full md:w-auto bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-3 rounded-xl font-bold transition-colors">
                        Reset
                    </a>
                </div>
                @endif
            </form>
        </div>
        
        <!-- Hasil -->
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-dark">Freelancer Tersedia</h2>
            <span class="text-sm font-medium bg-primary/10 text-primary px-4 py-1.5 rounded-full">{{ count($freelancers) }} Hasil</span>
        </div>
        
        @if(empty($freelancers))
            <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 border-dashed">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-lg font-bold text-gray-400">Belum ada freelancer yang sesuai kriteria.</p>
                <p class="text-gray-500 text-sm mt-1">Coba sesuaikan ulang filter kota atau keahlian jasa di atas.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach ($freelancers as $idx => $fl)
            <a href="{{ route('layanan.show', $fl['id_layanan'] ?? 1) }}"
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 block">

                <!-- Gambar -->
                <div class="relative bg-gray-100 h-32 flex items-center justify-center overflow-hidden">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="absolute top-2 right-2 bg-yellow-50 text-yellow-700 text-xs font-bold px-2 py-0.5 rounded-full flex items-center gap-1 border border-yellow-100">
                        <svg class="w-3 h-3 fill-current text-yellow-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ number_format($fl['avg_rating'], 1) }}
                    </span>
                </div>

                <!-- Info -->
                <div class="p-3.5">
                    <h3 class="font-bold text-dark text-sm leading-snug mb-0.5 truncate">{{ $fl['nama_jasa'] }}</h3>
                    <p class="text-xs text-gray-400 mb-2 truncate">{{ $fl['nama_pengguna'] }}</p>
                    <p class="text-sm font-extrabold text-dark mb-2">
                        Rp {{ number_format($fl['tarif'] ?? 0, 0, ',', '.') }}
                        <span class="font-normal text-gray-400 text-xs">/{{ $fl['nama_satuan'] ?? 'proyek' }}</span>
                    </p>
                    <div class="flex items-center gap-1 text-accent text-xs font-medium">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $fl['nama_kota'] !== '-' ? $fl['nama_kota'] : ($fl['alamat_lengkap'] ?? '-') }}
                    </div>
                    </div>
            </a>
            @endforeach
        </div>
        @endif
        
    </div>
</div>
@endsection
