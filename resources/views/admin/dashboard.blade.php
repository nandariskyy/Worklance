@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@section('header_content')
<div class="flex-1"></div>
@endsection

<!-- Page Title & Action -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
  <div>
    <h1 class="text-3xl font-bold text-dark mb-1">Dashboard Overview</h1>
    <p class="text-gray-500">Selamat datang kembali, lihat ringkasan aktivitas hari ini.</p>
  </div>
</div>

<!-- Chart Booking Per Bulan -->
<div class="mb-6 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
  <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Statistik Booking Tahun {{ date('Y') }}</h4>
  <div class="h-64 relative w-full">
      <canvas id="bookingBulanChart" data-chart="{{ json_encode($bookingPerBulan ?? []) }}"></canvas>
  </div>
</div>

<!-- Overview Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
  <!-- Stat 1: Total User -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition-all hover:-translate-y-1">
    <div class="flex justify-between items-start mb-4">
      <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
      </div>
    </div>
    <h3 class="text-gray-500 text-sm font-medium mb-1">Total User</h3>
    <p class="text-3xl font-bold text-dark">{{ number_format($totalUser, 0, ',', '.') }}</p>
  </div>

  <!-- Stat 2: Total Freelancer -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition-all hover:-translate-y-1">
    <div class="flex justify-between items-start mb-4">
      <div class="w-12 h-12 bg-orange-50 text-accent rounded-xl flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
      </div>
    </div>
    <h3 class="text-gray-500 text-sm font-medium mb-1">Total Freelancer</h3>
    <p class="text-3xl font-bold text-dark">{{ number_format($totalFreelancer, 0, ',', '.') }}</p>
  </div>

  <!-- Stat 3: Total Booking -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition-all hover:-translate-y-1">
    <div class="flex justify-between items-start mb-4">
      <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
        </svg>
      </div>
    </div>
    <h3 class="text-gray-500 text-sm font-medium mb-1">Total Booking</h3>
    <p class="text-3xl font-bold text-dark">{{ number_format($totalBooking, 0, ',', '.') }}</p>
  </div>

  <!-- Stat 4: Booking Selesai -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition-all hover:-translate-y-1">
    <div class="flex justify-between items-start mb-4">
      <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
    </div>
    <h3 class="text-gray-500 text-sm font-medium mb-1">Booking Selesai</h3>
    <p class="text-3xl font-bold text-dark">{{ number_format($totalSelesai, 0, ',', '.') }}</p>
  </div>
</div>

<!-- Main Columns -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

  <!-- Activity Table -->
  <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
      <h3 class="font-bold text-dark text-lg">Booking Terbaru</h3>
      <a href="{{ route('admin.booking') }}" class="text-accent text-sm font-bold hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse min-w-[700px]">
        <thead>
          <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
            <th class="p-4 pl-6 font-semibold">Nama Client</th>
            <th class="p-4 font-semibold">Jasa</th>
            <th class="p-4 font-semibold">Tanggal</th>
            <th class="p-4 font-semibold pr-6 text-right">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse ($bookingTerbaru as $bk)
          <tr class="hover:bg-gray-50/50 transition-colors">
            <td class="p-4 pl-6">
              <p class="font-bold text-dark text-sm whitespace-nowrap">{{ $bk['nama_client'] }}</p>
            </td>
            <td class="p-4">
              <p class="text-sm text-gray-600 whitespace-nowrap">{{ $bk['nama_jasa'] }}</p>
            </td>
            <td class="p-4 text-sm text-gray-500 whitespace-nowrap">
              {{ date('d-m-Y', strtotime($bk['tanggal_booking'])) }}
            </td>
            <td class="p-4 pr-6 text-right">
              @php
                  $statusBadge = 'bg-gray-100 text-gray-600 border-gray-200';
                  switch ($bk['status_booking']) {
                      case 'MENUNGGU': $statusBadge = 'bg-yellow-50 text-yellow-600 border-yellow-200'; break;
                      case 'DIPROSES': $statusBadge = 'bg-blue-50 text-blue-600 border-blue-200'; break;
                      case 'SELESAI': $statusBadge = 'bg-green-50 text-green-600 border-green-200'; break;
                  }
              @endphp
              <span class="px-3 py-1 {{ $statusBadge }} rounded-full text-[11px] font-bold border inline-block whitespace-nowrap">
                {{ $bk['status_booking'] }}
              </span>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="p-8 text-center text-gray-400">Belum ada data booking.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Sidebar Widgets -->
  <div class="space-y-6">
    <!-- New Pengajuan -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
      <h3 class="font-bold text-dark text-lg mb-4">Pengajuan Terbaru</h3>
      <div class="space-y-4">
        @forelse ($newPengajuan as $pj)
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-orange-50 text-accent flex items-center justify-center font-bold">
              {{ substr($pj['nama_pengguna'], 0, 1) }}
            </div>
            <div>
              <p class="text-sm font-bold text-dark mb-0.5">{{ $pj['nama_pengguna'] }}</p>
              <span class="px-2 py-0.5 bg-yellow-50 text-yellow-600 border border-yellow-200 rounded text-[10px] font-bold tracking-wide inline-block">{{ $pj['status'] }}</span>
            </div>
          </div>
          <a href="{{ route('admin.pengajuan') }}" class="text-sm px-3 py-1.5 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-lg font-bold transition-colors">Detail</a>
        </div>
        @empty
        <p class="text-gray-400 text-sm text-center py-4">Belum ada pengajuan.</p>
        @endforelse
      </div>
      <a href="{{ route('admin.pengajuan') }}" class="block w-full mt-5 py-2 text-sm font-bold text-gray-500 hover:bg-gray-50 hover:text-dark rounded-lg transition-colors border border-gray-200 text-center">
        Lihat Semua
      </a>
    </div>

    <!-- Top Categories -->
    <div class="bg-gradient-to-br from-dark to-[#1d2666] rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
      <div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3"></div>
      <h3 class="font-bold text-lg mb-6 relative z-10">Kategori Terpopuler</h3>
      <div class="space-y-5 relative z-10">
        @php $colorSet = ['bg-accent', 'bg-primary', 'bg-secondary']; @endphp
        @forelse ($kategoriPopuler as $idx => $kat)
        @php
            $persen = $maxKategori > 0 ? round(($kat['total'] / $maxKategori) * 100) : 0;
            $barColor = $colorSet[$idx % count($colorSet)];
        @endphp
        <div>
          <div class="flex justify-between text-sm mb-2">
            <span class="font-medium text-white">{{ $kat['nama_kategori'] }}</span>
            <span class="text-gray-300 font-bold">{{ $kat['total'] }} freelancer</span>
          </div>
          <div class="w-full bg-white/20 rounded-full h-2">
            <div class="{{ $barColor }} h-2 rounded-full" style="width: {{ $persen }}%"></div>
          </div>
        </div>
        @empty
        <p class="text-gray-400 text-sm text-center">Belum ada data kategori.</p>
        @endforelse
      </div>

      <!-- Chart Kategori -->
      <div class="mt-8">
        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Distribusi Kategori</h4>
        <div class="h-64 relative">
            <canvas id="kategoriChart" data-chart="{{ json_encode($kategoriPopuler ?? []) }}"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
@vite('resources/js/pages/admin/dashboard.js')
@endsection
