@extends('layouts.app')

@section('title', 'Riwayat Pesanan | WorkLance')

@section('content')
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow w-full relative z-0">
    <!-- Breadcrumb -->
    <nav class="flex items-center text-sm gap-2 font-medium mb-8">
      <a href="{{ url('/') }}" class="text-gray-500 hover:text-accent transition-colors">Beranda</a>
      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
      <span class="text-dark font-bold">Riwayat Pesanan</span>
    </nav>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
      <div>
        <h1 class="text-3xl font-bold text-dark flex items-center gap-3">
          Riwayat Pesanan
        </h1>
        <p class="text-gray-500 mt-2">Pantau status pesanan yang telah Anda buat kepada para freelancer.</p>
      </div>
    </div>

    @if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm">
      <svg class="w-5 h-5 flex-shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm">
      <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      {{ session('error') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm font-medium flex flex-col gap-2 shadow-sm">
      @foreach ($errors->all() as $err)
      <div class="flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ $err }}
      </div>
      @endforeach
    </div>
    @endif

    <!-- Container KLIEN -->
    <div>
        <!-- Tabs -->
        <div class="flex border-b border-gray-200 mb-8 overflow-x-auto hide-scrollbar">
          <button onclick="switchTab('aktif')" id="aktifBtn" class="px-6 py-4 font-bold text-accent border-b-2 border-accent transition-colors whitespace-nowrap">
            Berjalan / Menunggu ({{ count($klienAktif) }})
          </button>
          <button onclick="switchTab('selesai')" id="selesaiBtn" class="px-6 py-4 font-semibold text-gray-400 border-b-2 border-transparent hover:text-gray-600 transition-colors whitespace-nowrap">
            Selesai / Dibatalkan ({{ count($klienSelesai) }})
          </button>
        </div>

        <!-- Aktif -->
        <div id="aktifList" class="space-y-4 block">
          @if (empty($klienAktif))
            @include('components.empty_state', ['msg' => 'Anda belum membuat pesanan aktif.'])
          @else
            @foreach ($klienAktif as $p)
              @include('booking.card_klien', ['p' => $p, 'isActive' => true])
            @endforeach
          @endif
        </div>

        <!-- Selesai -->
        <div id="selesaiList" class="space-y-4 hidden">
          @if (empty($klienSelesai))
            @include('components.empty_state', ['msg' => 'Tidak ada riwayat pesanan selesai.'])
          @else
            @foreach ($klienSelesai as $p)
              @include('booking.card_klien', ['p' => $p, 'isActive' => false])
            @endforeach
          @endif
        </div>
    </div>
  </div>

  <script>
    function switchTab(tab) {
      const btnAktif = document.getElementById('aktifBtn');
      const btnSelesai = document.getElementById('selesaiBtn');
      const listAktif = document.getElementById('aktifList');
      const listSelesai = document.getElementById('selesaiList');

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
