@extends('layouts.admin')

@section('title', 'Kelola Booking | Admin WorkLance')

@section('content')
<!-- Page Title & Action -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-dark mb-1">Kelola Booking</h1>
    <p class="text-gray-500">Pantau dan kelola semua booking yang masuk.</p>
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

<!-- Filter Tabs -->
<div class="flex gap-2 mb-6 flex-wrap">
    <a href="{{ route('admin.booking') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeStatus ?? 'Semua') === 'Semua' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Semua</a>
    <a href="{{ route('admin.booking', ['status' => 'MENUNGGU']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeStatus ?? '') === 'MENUNGGU' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Menunggu</a>
    <a href="{{ route('admin.booking', ['status' => 'DIPROSES']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeStatus ?? '') === 'DIPROSES' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Diproses</a>
    <a href="{{ route('admin.booking', ['status' => 'SELESAI']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeStatus ?? '') === 'SELESAI' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Selesai</a>
    <a href="{{ route('admin.booking', ['status' => 'DIBATALKAN']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeStatus ?? '') === 'DIBATALKAN' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Dibatalkan</a>
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
            <td class="p-4 text-sm text-gray-500 whitespace-nowrap">{{ $bk['tanggal_booking'] }}</td>
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
                <form method="POST" action="{{ route('admin.booking.destroy', $bk['raw_id']) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
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
<div id="modalDetail" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Detail Booking</h3>
    <button onclick="document.getElementById('modalDetail').classList.add('hidden')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
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
        </div>
        
        <div class="mt-8">
            <button onclick="document.getElementById('modalDetail').classList.add('hidden')" class="w-full py-2.5 bg-gray-100 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-200 transition-colors">Tutup</button>
        </div>
    </div>
</div>
</div>

<script>
function openDetailModal(bk) {
    document.getElementById('detail_id').innerText = bk.id_booking;
    document.getElementById('detail_client').innerText = bk.nama_client;
    document.getElementById('detail_freelancer').innerText = bk.nama_freelancer;
    document.getElementById('detail_jasa').innerText = bk.nama_jasa;
    document.getElementById('detail_tanggal').innerText = bk.tanggal_booking;
    
    const statusSpan = document.getElementById('detail_status');
    statusSpan.innerText = bk.status_booking;
    
    // reset classes
    statusSpan.className = "px-3 py-1 rounded-full text-[11px] font-bold border inline-block ";
    if (bk.status_booking === 'MENUNGGU') statusSpan.className += "bg-gray-100 text-gray-600 border-gray-200";
    if (bk.status_booking === 'DIPROSES') statusSpan.className += "bg-yellow-50 text-yellow-600 border-yellow-200";
    if (bk.status_booking === 'SELESAI') statusSpan.className += "bg-green-50 text-green-600 border-green-200";
    if (bk.status_booking === 'DIBATALKAN') statusSpan.className += "bg-red-50 text-red-600 border-red-200";
    
    document.getElementById('modalDetail').classList.remove('hidden');
}
</script>

@endsection
