@extends('layouts.admin')

@section('title', 'Kelola Booking | Admin WorkLance')

@section('content')
@section('header_content')
<div class="hidden sm:flex flex-1 max-w-lg items-center relative">
    <svg class="w-5 h-5 text-gray-400 absolute left-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    <form method="GET" action="{{ route('admin.booking') }}" class="w-full">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID Booking atau Nama Client..." class="w-full bg-gray-100/50 border border-transparent focus:border-gray-200 hover:bg-gray-100 rounded-full pl-12 pr-4 py-2.5 text-sm outline-none transition-all placeholder-gray-400 text-dark">
    </form>
</div>
@endsection
<!-- Page Title & Action -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-dark mb-1">Kelola Booking</h1>
        <p class="text-gray-500">Pantau dan kelola semua booking yang masuk.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.export') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Data
        </a>
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

<!-- Status Stats (Mock Data) -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('admin.booking') }}" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow text-center {{ ($activeStatus ?? 'Semua') === 'Semua' ? 'ring-2 ring-accent' : '' }}">
        <p class="text-2xl font-bold text-dark">{{ $stats['Semua'] ?? count($bookingList ?? []) }}</p>
        <p class="text-xs text-gray-500 font-medium mt-1">Semua</p>
    </a>
    <a href="{{ route('admin.booking', ['status' => 'DIPROSES']) }}" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow text-center {{ ($activeStatus ?? '') === 'DIPROSES' ? 'ring-2 ring-yellow-400' : '' }}">
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['Diproses'] ?? 0 }}</p>
        <p class="text-xs text-gray-500 font-medium mt-1">Diproses</p>
    </a>
    <a href="{{ route('admin.booking', ['status' => 'SELESAI']) }}" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow text-center {{ ($activeStatus ?? '') === 'SELESAI' ? 'ring-2 ring-green-400' : '' }}">
        <p class="text-2xl font-bold text-green-600">{{ $stats['Selesai'] ?? 0 }}</p>
        <p class="text-xs text-gray-500 font-medium mt-1">Selesai</p>
    </a>
    <a href="{{ route('admin.booking', ['status' => 'DIBATALKAN']) }}" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow text-center {{ ($activeStatus ?? '') === 'DIBATALKAN' ? 'ring-2 ring-red-400' : '' }}">
        <p class="text-2xl font-bold text-red-600">{{ $stats['Dibatalkan'] ?? 0 }}</p>
        <p class="text-xs text-gray-500 font-medium mt-1">Dibatalkan</p>
    </a>
</div>

<!-- Chart Status Booking -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 hover:shadow-md transition-shadow flex flex-col items-center">
    <h4 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-wider w-full text-left">Statistik Status Booking</h4>
    <div class="w-full max-w-md h-64 relative">
        <canvas id="bookingChart" data-stats="{{ json_encode($stats ?? []) }}"></canvas>
    </div>
</div>

<!-- Filter Tabs -->
<div class="mb-6">
    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('admin.booking') }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ ($activeStatus ?? 'Semua') === 'Semua' ? 'bg-dark text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 hover:shadow-sm' }}">Semua</a>
        <a href="{{ route('admin.booking', ['status' => 'MENUNGGU']) }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ ($activeStatus ?? '') === 'MENUNGGU' ? 'bg-dark text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 hover:shadow-sm' }}">Menunggu</a>
        <a href="{{ route('admin.booking', ['status' => 'DIPROSES']) }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ ($activeStatus ?? '') === 'DIPROSES' ? 'bg-dark text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 hover:shadow-sm' }}">Diproses</a>
        <a href="{{ route('admin.booking', ['status' => 'SELESAI']) }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ ($activeStatus ?? '') === 'SELESAI' ? 'bg-dark text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 hover:shadow-sm' }}">Selesai</a>
        <a href="{{ route('admin.booking', ['status' => 'DIBATALKAN']) }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ ($activeStatus ?? '') === 'DIBATALKAN' ? 'bg-dark text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 hover:shadow-sm' }}">Dibatalkan</a>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
        <thead>
            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
            <th class="p-4 pl-6 font-semibold">ID</th>
            <th class="p-4 font-semibold">Client</th>
            <th class="p-4 font-semibold">Freelancer</th>
            <th class="p-4 font-semibold">Jasa</th>
            <th class="p-4 font-semibold">Tanggal</th>
            <th class="p-4 font-semibold">Status</th>
            <th class="p-4 font-semibold pr-6 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($bookingList ?? [] as $bk)
            <tr class="hover:bg-gray-50/50 transition-colors">
            <td class="p-4 pl-6 text-sm text-gray-500">{{ $bk['id_booking'] }}</td>
            <td class="p-4">
                <p class="font-bold text-dark text-sm whitespace-nowrap">{{ $bk['nama_client'] }}</p>
            </td>
            <td class="p-4 text-sm font-semibold text-accent whitespace-nowrap">{{ $bk['nama_freelancer'] }}</td>
            <td class="p-4 text-sm text-gray-600">{{ $bk['nama_jasa'] }}</td>
            <td class="p-4 text-sm text-gray-500 whitespace-nowrap">{{ date('d-m-Y', strtotime($bk['tanggal_booking'])) }}</td>
            <td class="p-4">
                @php
                $statusBadge = 'bg-gray-100 text-gray-600 border-gray-200';
                if (($bk['status_booking'] ?? '') == 'MENUNGGU') $statusBadge = 'bg-gray-100 text-gray-600 border-gray-200';
                if (($bk['status_booking'] ?? '') == 'DIPROSES') $statusBadge = 'bg-yellow-50 text-yellow-600 border-yellow-200';
                if (($bk['status_booking'] ?? '') == 'SELESAI') $statusBadge = 'bg-green-50 text-green-600 border-green-200';
                if (($bk['status_booking'] ?? '') == 'DIBATALKAN') $statusBadge = 'bg-red-50 text-red-600 border-red-200';
                @endphp
                <span class="px-3 py-1 {{ $statusBadge }} rounded-full text-[11px] font-bold border inline-block whitespace-nowrap">{{ $bk['status_booking'] }}</span>
            </td>
            <td class="p-4 pr-6 text-right">
                <div class="flex items-center justify-end gap-2">
                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail" onclick="openDetailModal({{ json_encode($bk) }})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
                </div>
            </td>
            </tr>
            @empty
            <tr><td colspan="7" class="p-8 text-center text-gray-400">Tidak ada data booking.</td></tr>
            @endforelse
        </tbody>
        </table>
    </div>
</div>
</div>

<!-- Modal Detail Booking -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all duration-300">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="modalDetailContent">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Detail Booking</h3>
    <button onclick="closeModal('modalDetail')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    </div>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">ID Booking</p>
                <h4 id="detail_id" class="text-xl font-bold text-dark"></h4>
            </div>
            <div>
                <span id="detail_status" class="px-3 py-1 bg-gray-100 text-gray-600 border border-gray-200 rounded-full text-[11px] font-bold inline-block"></span>
            </div>
        </div>
        
        <div class="space-y-4">
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Klien (Pemesan)</p>
                <p id="detail_client" class="text-sm font-medium text-dark"></p>
                <p id="detail_client_contact" class="text-xs text-gray-500 mt-0.5"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Freelancer</p>
                <p id="detail_freelancer" class="text-sm font-bold text-accent"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Jasa yang Dipesan</p>
                <p id="detail_jasa" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Tanggal Booking</p>
                <p id="detail_tanggal" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Alamat Booking</p>
                <p id="detail_alamat" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Catatan Booking</p>
                <p id="detail_catatan" class="text-sm font-medium text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-100"></p>
            </div>
        </div>
        
        <div class="mt-8">
            <button onclick="closeModal('modalDetail')" class="w-full py-2.5 bg-gray-100 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-200 transition-colors">Tutup</button>
        </div>
    </div>
</div>
</div>

@vite('resources/js/pages/admin/booking.js')

@endsection
