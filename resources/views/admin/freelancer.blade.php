@extends('layouts.admin')

@section('title', 'Kelola Freelancer | Admin WorkLance')

@section('content')
@section('header_content')
<div class="hidden sm:flex flex-1 max-w-lg items-center relative">
    <svg class="w-5 h-5 text-gray-400 absolute left-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    <form method="GET" action="{{ route('admin.freelancer') }}" class="w-full">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari freelancer..." class="w-full bg-gray-100/50 border border-transparent focus:border-gray-200 hover:bg-gray-100 rounded-full pl-12 pr-4 py-2.5 text-sm outline-none transition-all placeholder-gray-400 text-dark">
    </form>
</div>
@endsection
<!-- Page Title & Action -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-dark mb-1">Kelola Freelancer</h1>
        <p class="text-gray-500">Total {{ count($freelancerList ?? []) }} freelancer terdaftar.</p>
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

<!-- Filter Tabs -->
<div class="flex gap-2 mb-6 flex-wrap">
    <a href="{{ route('admin.freelancer') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeKategori ?? 'Semua') === 'Semua' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Semua</a>
    @foreach($kategoriList ?? [] as $kat)
    <a href="{{ route('admin.freelancer', ['kategori' => $kat->nama_kategori]) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeKategori ?? '') === $kat->nama_kategori ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">{{ $kat->nama_kategori }}</a>
    @endforeach
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
        <thead>
            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
            <th class="p-4 pl-6 font-semibold">ID</th>
            <th class="p-4 font-semibold">Nama</th>
            <th class="p-4 font-semibold">Kategori</th>
            <th class="p-4 font-semibold">Jasa</th>
            <th class="p-4 font-semibold">Tarif</th>
            <th class="p-4 font-semibold">Satuan</th>
            <th class="p-4 font-semibold pr-6 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($freelancerList ?? [] as $fl)
            <tr class="hover:bg-gray-50/50 transition-colors">
            <td class="p-4 pl-6 text-sm text-gray-500">{{ $fl['id_layanan'] }}</td>
            <td class="p-4">
                <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-accent/10 text-accent flex items-center justify-center font-bold text-xs">{{ substr($fl['nama_pengguna'], 0, 1) }}</div>
                <div>
                    <p class="font-bold text-dark text-sm whitespace-nowrap">{{ $fl['nama_pengguna'] }}</p>
                    <p class="text-xs text-gray-400">{{ $fl['email'] }}</p>
                </div>
                </div>
            </td>
            <td class="p-4">
                <span class="px-3 py-1 bg-blue-50 text-blue-600 border border-blue-200 rounded-full text-[11px] font-bold inline-block">{{ $fl['kategori'] ?? '-' }}</span>
            </td>
            <td class="p-4 text-sm font-medium text-dark">{{ $fl['jasa'] ?? '-' }}</td>
            <td class="p-4 text-sm text-gray-600 whitespace-nowrap">Rp {{ number_format($fl['tarif'] ?? 0, 0, ',', '.') }}</td>
            <td class="p-4 text-sm text-gray-500">{{ $fl['satuan'] ?? '-' }}</td>
            <td class="p-4 pr-6 text-right">
                <div class="flex items-center justify-end gap-2">
                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail" onclick="openDetailModal({{ json_encode($fl) }})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
                <form method="POST" action="{{ route('admin.freelancer.revoke', $fl['id_pengguna']) }}" class="inline-block" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin mencabut akses freelancer ini? Statusnya akan kembali menjadi Klien.');">
                    @csrf
                    <button type="submit" class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Cabut Akses Freelancer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    </button>
                </form>
                </div>
            </td>
            </tr>
            @empty
            <tr><td colspan="5" class="p-8 text-center text-gray-400">Tidak ada data freelancer.</td></tr>
            @endforelse
        </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail Freelancer -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all duration-300">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="modalDetailContent">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Detail Freelancer</h3>
    <button onclick="closeModal('modalDetail')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    </div>
    <div class="p-6">
        <div class="flex items-center gap-4 mb-6">
            <div id="detail_avatar" class="w-16 h-16 rounded-full bg-accent/10 text-accent flex items-center justify-center font-bold text-2xl"></div>
            <div>
                <h4 id="detail_nama_pengguna" class="text-xl font-bold text-dark"></h4>
                <p id="detail_email" class="text-sm font-semibold text-gray-500"></p>
            </div>
        </div>
        
        <div class="space-y-4">
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">ID Freelancer</p>
                <p id="detail_id" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Kategori Spesialisasi</p>
                <p id="detail_kategori" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Status</p>
                <span id="detail_status" class="px-3 py-1 bg-green-50 text-green-600 border border-green-200 rounded-full text-[11px] font-bold inline-block"></span>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">No. Telepon</p>
                <p id="detail_no_telp" class="text-sm font-medium text-dark"></p>
            </div>
        </div>
        
        <div class="mt-8">
            <button onclick="closeModal('modalDetail')" class="w-full py-2.5 bg-gray-100 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-200 transition-colors">Tutup</button>
        </div>
    </div>
</div>
</div>

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    const content = document.getElementById(id + 'Content');
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeModal(id) {
    const modal = document.getElementById(id);
    const content = document.getElementById(id + 'Content');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function openDetailModal(fl) {
    document.getElementById('detail_avatar').innerText = (fl.nama_pengguna || 'F').substring(0, 1).toUpperCase();
    document.getElementById('detail_nama_pengguna').innerText = fl.nama_pengguna;
    document.getElementById('detail_email').innerText = fl.email;
    document.getElementById('detail_id').innerText = fl.id_layanan;
    document.getElementById('detail_kategori').innerText = fl.kategori || '-';
    document.getElementById('detail_no_telp').innerText = fl.no_telp || '-';
    document.getElementById('detail_status').innerText = fl.status || 'Aktif';
    
    openModal('modalDetail');
}
</script>

@endsection
