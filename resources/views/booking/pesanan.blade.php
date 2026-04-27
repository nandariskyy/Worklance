@extends('layouts.app')

@section('title', 'Pesanan | WorkLance')

@section('content')
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow w-full relative z-0">
    <!-- Breadcrumb -->
    <nav class="flex items-center text-sm gap-2 font-medium mb-8">
      <a href="{{ url('/') }}" class="text-gray-500 hover:text-accent transition-colors">Beranda</a>
      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
      <span class="text-dark font-bold">Pesanan Saya</span>
    </nav>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
      <div>
        <h1 class="text-3xl font-bold text-dark flex items-center gap-3">
          Pesanan & Pekerjaan
        </h1>
        <p class="text-gray-500 mt-2">Pantau status pesanan yang Anda buat atau pekerjaan yang harus Anda selesaikan.</p>
      </div>
    </div>

    @if ($success)
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm">
      <svg class="w-5 h-5 flex-shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      {{ $success }}
    </div>
    @endif
    @if ($error)
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm">
      <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      {{ $error }}
    </div>
    @endif

    <!-- Tabs -->
    <div class="flex border-b border-gray-200 mb-8 overflow-x-auto hide-scrollbar">
      <button onclick="switchPesananTab('aktif')" id="tabAktifBtn" class="px-6 py-4 font-bold text-accent border-b-2 border-accent transition-colors whitespace-nowrap">
        Berjalan / Menunggu ({{ count($pesananAktif) }})
      </button>
      <button onclick="switchPesananTab('selesai')" id="tabSelesaiBtn" class="px-6 py-4 font-semibold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-colors whitespace-nowrap">
        Selesai / Dibatalkan ({{ count($pesananSelesai) }})
      </button>
    </div>

    <!-- Aktif List -->
    <div id="listAktif" class="space-y-4 block">
      @if (empty($pesananAktif))
      <div class="text-center py-20 bg-white border border-gray-100 border-dashed rounded-3xl">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        <p class="text-lg font-bold text-gray-400">Belum ada pesanan aktif.</p>
      </div>
      @else
        @foreach ($pesananAktif as $p)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-6 items-start hover:shadow-md transition-all">
          <div class="flex-grow">
            <div class="flex items-center gap-3 mb-2">
              <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-yellow-100 text-yellow-700 rounded-md">{{ $p['status_booking'] }}</span>
              <span class="text-xs font-semibold text-gray-400">{{ date('d M Y', strtotime($p['tanggal_booking'])) }}</span>
            </div>
            <h2 class="text-xl font-bold text-dark mb-1">{{ $p['nama_jasa'] }}</h2>
            <p class="text-sm font-medium text-accent mb-4">{{ $p['nama_kategori'] }}</p>
            <div class="text-sm text-gray-600">
              <p><strong>Klien:</strong> {{ $p['nama_klien'] }} ({{ $p['no_telp_klien'] }})</p>
              <p><strong>Alamat:</strong> {{ $p['alamat_booking'] }}</p>
              <p><strong>Catatan:</strong> {{ $p['catatan'] }}</p>
            </div>
          </div>
        </div>
        @endforeach
      @endif
    </div>

    <!-- Selesai List -->
    <div id="listSelesai" class="space-y-4 hidden">
      @if (empty($pesananSelesai))
      <div class="text-center py-20 bg-white border border-gray-100 border-dashed rounded-3xl">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        <p class="text-lg font-bold text-gray-400">Belum ada riwayat pesanan.</p>
      </div>
      @else
        @foreach ($pesananSelesai as $p)
        <div class="bg-gray-50 rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-6 items-start opacity-75 hover:opacity-100 transition-opacity">
          <div class="flex-grow">
            <div class="flex items-center gap-3 mb-2">
              <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-gray-200 text-gray-600 rounded-md">{{ $p['status_booking'] }}</span>
              <span class="text-xs font-semibold text-gray-400">{{ date('d M Y', strtotime($p['tanggal_booking'])) }}</span>
            </div>
            <h2 class="text-xl font-bold text-gray-700 mb-1">{{ $p['nama_jasa'] }}</h2>
            <p class="text-sm font-medium text-gray-500 mb-4">Klien: {{ $p['nama_klien'] }}</p>
            @if (isset($p['rating']))
            <div class="bg-white p-3 rounded-xl border border-gray-100 inline-block">
              <div class="flex items-center gap-1 text-yellow-400 mb-1">
                @for ($i=1; $i<=5; $i++)
                  <svg class="w-4 h-4 {{ $i <= $p['rating'] ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                @endfor
              </div>
              <p class="text-xs text-gray-500 italic">"{{ $p['komentar'] }}"</p>
            </div>
            @endif
          </div>
        </div>
        @endforeach
      @endif
    </div>
  </div>

  <script>
    function switchPesananTab(tab) {
      const btnAktif = document.getElementById('tabAktifBtn');
      const btnSelesai = document.getElementById('tabSelesaiBtn');
      const listAktif = document.getElementById('listAktif');
      const listSelesai = document.getElementById('listSelesai');

      if (tab === 'aktif') {
        listAktif.classList.remove('hidden');
        listAktif.classList.add('block');
        listSelesai.classList.add('hidden');
        listSelesai.classList.remove('block');

        btnAktif.classList.add('text-accent', 'border-accent');
        btnAktif.classList.remove('text-gray-400', 'border-transparent');
        btnSelesai.classList.remove('text-accent', 'border-accent');
        btnSelesai.classList.add('text-gray-400', 'border-transparent');
      } else {
        listSelesai.classList.remove('hidden');
        listSelesai.classList.add('block');
        listAktif.classList.add('hidden');
        listAktif.classList.remove('block');

        btnSelesai.classList.add('text-accent', 'border-accent');
        btnSelesai.classList.remove('text-gray-400', 'border-transparent');
        btnAktif.classList.remove('text-accent', 'border-accent');
        btnAktif.classList.add('text-gray-400', 'border-transparent');
      }
    }
  </script>
@endsection
