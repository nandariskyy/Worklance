@extends('layouts.app')

@section('title', $profileData['nama_pengguna'] . ' - Profil Freelancer | WorkLance')

@section('content')
<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 flex-grow w-full">
  <div class="flex flex-col lg:flex-row gap-8 items-start">

    <!-- ===================== KOLOM KIRI ===================== -->
    <div class="w-full lg:w-3/5 space-y-0">

      <!-- Kartu Identitas + Ulasan (satu kotak) -->
      <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 flex flex-col gap-5">

        <!-- Avatar & Nama — lebih lebar -->
        <div class="flex items-center gap-5">
          @if(!empty($profileData['foto_profil']))
            <img src="{{ asset('storage/' . $profileData['foto_profil']) }}"
                 alt="Avatar"
                 class="w-24 h-24 rounded-full border-4 border-white shadow-md object-cover flex-shrink-0">
          @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($profileData['nama_pengguna']) }}&background=96B3BF&color=fff&size=200"
                 alt="Avatar"
                 class="w-24 h-24 rounded-full border-4 border-white shadow-md object-cover flex-shrink-0">
          @endif
          <div class="flex-1 min-w-0">
            <h2 class="text-xl font-bold text-dark leading-tight break-words">{{ $profileData['nama_pengguna'] }}</h2>
          </div>
        </div>

        <!-- Rating & Lokasi -->
        <div class="flex flex-wrap gap-2">
          <div class="flex items-center gap-1.5 bg-yellow-50 text-yellow-700 text-sm font-bold px-3 py-1.5 rounded-full border border-yellow-100">
            <svg class="w-4 h-4 fill-current text-yellow-400" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            {{ $avg_rating }}
            <span class="font-normal text-yellow-600">({{ $total_ulasan }} Ulasan)</span>
          </div>
          <div class="flex items-center gap-1.5 text-sm text-gray-500 bg-gray-50 px-3 py-1.5 rounded-full border border-gray-100">
            <svg class="w-4 h-4 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            {{ $profileData['nama_kota'] ?? '-' }}
          </div>
        </div>

        <!-- Deskripsi -->
        @if (!empty($profileData['deskripsi']))
        <p class="text-sm text-gray-500 leading-relaxed border-t border-gray-100 pt-4">
          {{ $profileData['deskripsi'] }}
        </p>
        @endif

        <!-- ===== ULASAN langsung di bawah, satu kotak ===== -->
        <div class="border-t border-gray-100 pt-5">
          <h3 class="text-base font-bold text-dark mb-4">Ulasan</h3>

          @if (empty($ulasanList))
            <p class="text-sm text-gray-400 text-center py-4">Belum ada ulasan.</p>
          @else
            <div class="space-y-4">
              @foreach ($ulasanList as $u)
              <div class="border-t border-gray-100 pt-4 first:border-0 first:pt-0">
                <div class="flex items-center justify-between mb-1">
                  <span class="text-sm font-bold text-dark">{{ $u['nama_pengguna'] }}</span>
                  <span class="text-xs text-gray-400">{{ date('d M Y', strtotime($u['tanggal_ulasan'])) }}</span>
                </div>
                <div class="flex items-center gap-0.5 mb-1.5 text-yellow-400">
                  @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-3.5 h-3.5 fill-current {{ $i <= $u['rating'] ? 'text-yellow-400' : 'text-gray-200' }}" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                  @endfor
                </div>
                <p class="text-sm text-gray-500 leading-relaxed">{!! nl2br(htmlspecialchars($u['komentar'])) !!}</p>
              </div>
              @endforeach
            </div>
          @endif
        </div>

      </div>
      <!-- END satu kotak kiri -->

    </div>
    <!-- END KOLOM KIRI -->

    <!-- ===================== KOLOM KANAN ===================== -->
    <div class="w-full lg:w-3/5 space-y-4">

      <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
        Jasa yang ditawarkan oleh {{ $profileData['nama_pengguna'] }}
      </p>

      <!-- Grid Jasa — lebih kecil -->
      <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse ($jasaList as $jasa)
        <a href="{{ route('layanan.show', $jasa['id_layanan']) }}"
           class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 block">

          <!-- Gambar lebih kecil -->
          <div class="relative bg-gray-100 h-32 flex items-center justify-center overflow-hidden">
            @if (!empty($jasa['gambar']))
              <img src="{{ $jasa['gambar'] }}" alt="{{ $jasa['nama_jasa'] }}" class="w-full h-full object-cover">
            @else
              <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            @endif
            <span class="absolute top-2 right-2 bg-yellow-50 text-yellow-700 text-xs font-bold px-2 py-0.5 rounded-full flex items-center gap-1 border border-yellow-100">
              <svg class="w-3 h-3 fill-current text-yellow-400" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
              </svg>
              {{ number_format($jasa['avg_rating'] ?? 5.0, 1) }}
            </span>
          </div>

          <!-- Info lebih compact -->
          <div class="p-3.5">
            <h3 class="font-bold text-dark text-sm leading-snug mb-0.5 truncate">{{ $jasa['nama_jasa'] }}</h3>
            <p class="text-xs text-gray-400 mb-2 truncate">{{ $profileData['nama_pengguna'] }}</p>
            <p class="text-sm font-extrabold text-dark mb-2">
              Rp {{ number_format($jasa['tarif'], 0, ',', '.') }}
              <span class="font-normal text-gray-400 text-xs">/{{ $jasa['nama_satuan'] ?? 'proyek' }}</span>
            </p>
            <div class="flex items-center gap-1 text-accent text-xs font-medium">
              <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              {{ $profileData['nama_kota'] ?? '-' }}
            </div>
          </div>
        </a>
        @empty
          @for ($i = 0; $i < 4; $i++)
          <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-100 h-32 flex items-center justify-center">
              <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
            <div class="p-3.5 space-y-2">
              <div class="h-3.5 bg-gray-200 rounded-full w-3/4 animate-pulse"></div>
              <div class="h-3 bg-gray-100 rounded-full w-1/2 animate-pulse"></div>
              <div class="h-3.5 bg-gray-200 rounded-full w-1/3 animate-pulse mt-2"></div>
            </div>
          </div>
          @endfor
        @endforelse
      </div>

    </div>
    <!-- END KOLOM KANAN -->

  </div>
</main>
@endsection