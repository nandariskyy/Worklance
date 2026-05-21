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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($freelancers as $idx => $fl)
                <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group hover:-translate-y-1">
                <div class="p-8 relative flex flex-col h-full">
                    <div class="absolute top-5 right-5 bg-yellow-50 text-yellow-700 text-sm font-bold px-3 py-1 rounded-full flex items-center border border-yellow-200">
                    <svg class="w-4 h-4 mr-1 pb-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    {{ number_format($fl['avg_rating'], 1) }}
                    </div>
                    <div class="flex justify-center mb-6 mt-4">
                    <div class="w-28 h-28 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-4xl ring-4 ring-primary/20 group-hover:ring-primary/50 transition-all p-1">
                        {{ substr($fl['nama_pengguna'], 0, 1) }}
                    </div>
                    </div>
                    <div class="text-center flex-grow">
                    <h3 class="text-xl font-bold text-dark mb-1">{{ $fl['nama_pengguna'] }}</h3>
                    <p class="text-accent font-medium text-sm mb-4">{{ $fl['nama_jasa'] }}</p>
                    <div class="flex flex-col items-center justify-center text-gray-500 text-sm mb-6 bg-gray-50 py-2 px-3 rounded-xl w-full mx-auto">
                        <div class="flex items-center text-dark font-semibold mb-1">
                            <svg class="w-4 h-4 mr-1.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ $fl['nama_kota'] ?: 'Kota Tidak Diketahui' }}
                        </div>
                        <span class="text-xs truncate w-full text-center" title="{{ $fl['alamat_lengkap'] }}">{{ $fl['alamat_lengkap'] ?: '-' }}</span>
                    </div>
                    </div>
                    <a href="{{ route('layanan.show', $fl['id_layanan'] ?? 1) }}" class="block text-center w-full bg-gray-50 border border-gray-200 text-dark group-hover:bg-dark group-hover:text-white group-hover:border-dark py-3 rounded-xl transition-all duration-300 font-semibold mt-auto">Lihat Profil</a>
                </div>
                </div>
                @endforeach
            </div>
        @endif
        
    </div>
</div>
@endsection
