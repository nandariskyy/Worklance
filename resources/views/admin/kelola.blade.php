@extends('layouts.admin')

@section('title', 'Kelola Kategori & Jasa | Admin WorkLance')

@section('content')
@section('header_content')
<div class="flex-1">
    <h2 class="text-lg font-bold text-dark">Kategori, Jasa & Satuan</h2>
</div>
@endsection
<!-- Page Title & Action -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-dark mb-1">Kelola Kategori & Jasa</h1>
    <p class="text-gray-500">Atur kategori layanan, jasa, dan satuan tarif.</p>
</div>

@if (session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm">
    <svg class="w-5 h-5 flex-shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    {{ session('success') }}
</div>
@endif

<!-- Tabs -->
@php
    $activeTab = request('tab', 'jasa');
@endphp
<div class="flex gap-1 mb-8 bg-gray-100 rounded-xl p-1 w-fit">
    <a href="{{ route('admin.kelola', ['tab' => 'jasa']) }}" class="px-5 py-2.5 rounded-lg text-sm font-bold transition-colors {{ $activeTab === 'jasa' ? 'bg-white text-dark shadow-sm' : 'text-gray-500 hover:text-dark' }}">Jasa</a>
    <a href="{{ route('admin.kelola', ['tab' => 'satuan']) }}" class="px-5 py-2.5 rounded-lg text-sm font-bold transition-colors {{ $activeTab === 'satuan' ? 'bg-white text-dark shadow-sm' : 'text-gray-500 hover:text-dark' }}">Satuan</a>
</div>

@if ($activeTab === 'jasa')
<!-- ============ JASA TAB ============ -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-dark text-lg mb-4">Tambah Jasa</h3>
        <form method="POST" action="{{ route('admin.kelola.jasa') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-bold text-dark mb-1.5">Kategori <span class="text-red-500">*</span></label>
            <select name="id_kategori" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoriList ?? [] as $k)
                <option value="{{ $k['id_kategori'] }}">{{ $k['nama_kategori'] }}</option>
            @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-bold text-dark mb-1.5">Nama Jasa <span class="text-red-500">*</span></label>
            <input type="text" name="nama_jasa" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium" placeholder="cth: Desain Logo">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="flex-1 py-2.5 bg-accent text-white text-sm font-bold rounded-xl shadow-md hover:bg-orange-700 transition-colors cursor-pointer">Simpan</button>
        </div>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="font-bold text-dark text-lg">Daftar Jasa ({{ count($jasaList ?? []) }})</h3>
        </div>
        <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                <th class="p-4 pl-6 font-semibold">ID</th>
                <th class="p-4 font-semibold">Nama Jasa</th>
                <th class="p-4 font-semibold">Kategori</th>
                <th class="p-4 font-semibold pr-6 text-right">Aksi</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse ($jasaList ?? [] as $js)
            <tr class="hover:bg-gray-50/50 transition-colors">
                <td class="p-4 pl-6 text-sm text-gray-500">{{ $js['id_jasa'] }}</td>
                <td class="p-4 font-bold text-dark text-sm">{{ $js['nama_jasa'] }}</td>
                <td class="p-4">
                <span class="px-3 py-1 bg-blue-50 text-blue-600 border border-blue-200 rounded-full text-[11px] font-bold inline-block">{{ $js['kategori'] ?? '-' }}</span>
                </td>
                <td class="p-4 pr-6 text-right">
                <div class="flex items-center justify-end gap-2">
                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit" onclick="openEditJasaModal({{ json_encode($js) }})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <form method="POST" action="{{ route('admin.kelola.jasa.destroy', $js['id_jasa']) }}" class="inline-block" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus jasa ini?');">
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
            <tr><td colspan="4" class="p-8 text-center text-gray-400">Belum ada data jasa.</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
</div>
</div>
@elseif ($activeTab === 'satuan')
<!-- ============ SATUAN TAB ============ -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-dark text-lg mb-4">Tambah Satuan</h3>
        <form method="POST" action="{{ route('admin.kelola.satuan') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-bold text-dark mb-1.5">Nama Satuan <span class="text-red-500">*</span></label>
            <input type="text" name="nama_satuan" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium" placeholder="cth: Per Proyek">
        </div>
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 py-2.5 bg-accent text-white text-sm font-bold rounded-xl shadow-md hover:bg-orange-700 transition-colors cursor-pointer">Simpan</button>
        </div>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="font-bold text-dark text-lg">Daftar Satuan ({{ count($satuanList ?? []) }})</h3>
        </div>
        <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                <th class="p-4 pl-6 font-semibold">ID</th>
                <th class="p-4 font-semibold">Nama Satuan</th>
                <th class="p-4 font-semibold pr-6 text-right">Aksi</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse ($satuanList ?? [] as $st)
            <tr class="hover:bg-gray-50/50 transition-colors">
                <td class="p-4 pl-6 text-sm text-gray-500">{{ $st['id_satuan'] }}</td>
                <td class="p-4 font-bold text-dark text-sm">{{ $st['nama_satuan'] }}</td>
                <td class="p-4 pr-6 text-right">
                <div class="flex items-center justify-end gap-2">
                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit" onclick="openEditSatuanModal({{ json_encode($st) }})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <form method="POST" action="{{ route('admin.kelola.satuan.destroy', $st['id_satuan']) }}" class="inline-block" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus satuan ini?');">
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
            <tr><td colspan="3" class="p-8 text-center text-gray-400">Belum ada data satuan.</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endif

<!-- Modal Edit Satuan -->
<div id="modalEditSatuan" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all duration-300">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0" id="modalEditSatuanContent">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Edit Satuan</h3>
    <button onclick="closeModal('modalEditSatuan')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    </div>
    <form id="formEditSatuan" method="POST" action="" class="p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-bold text-dark mb-1.5">Nama Satuan <span class="text-red-500">*</span></label>
            <input type="text" id="edit_nama_satuan" name="nama_satuan" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
        <div class="flex gap-3 pt-4">
            <button type="button" onclick="closeModal('modalEditSatuan')" class="flex-1 py-2.5 text-center text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-xl border border-gray-200 transition-colors">Batal</button>
            <button type="submit" class="flex-1 py-2.5 bg-accent text-white text-sm font-bold rounded-xl shadow-md hover:bg-orange-700 transition-colors cursor-pointer">Perbarui</button>
        </div>
    </form>
</div>
</div>



<!-- Modal Edit Jasa -->
<div id="modalEditJasa" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all duration-300">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0" id="modalEditJasaContent">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Edit Jasa</h3>
    <button onclick="closeModal('modalEditJasa')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    </div>
    <form id="formEditJasa" method="POST" action="" class="p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-bold text-dark mb-1.5">Kategori <span class="text-red-500">*</span></label>
            <select id="edit_id_kategori_jasa" name="id_kategori" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoriList ?? [] as $k)
                <option value="{{ $k['id_kategori'] }}">{{ $k['nama_kategori'] }}</option>
            @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-bold text-dark mb-1.5">Nama Jasa <span class="text-red-500">*</span></label>
            <input type="text" id="edit_nama_jasa" name="nama_jasa" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
        <div class="flex gap-3 pt-4">
            <button type="button" onclick="closeModal('modalEditJasa')" class="flex-1 py-2.5 text-center text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-xl border border-gray-200 transition-colors">Batal</button>
            <button type="submit" class="flex-1 py-2.5 bg-accent text-white text-sm font-bold rounded-xl shadow-md hover:bg-orange-700 transition-colors cursor-pointer">Perbarui</button>
        </div>
    </form>
</div>
</div>

@vite('resources/js/pages/admin/kelola.js')

@endsection
