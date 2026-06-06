@extends('layouts.admin')

@section('title', 'Kelola Pengguna | Admin WorkLance')

@section('content')
@section('header_content')
<div class="hidden sm:flex flex-1 max-w-lg items-center relative">
    <svg class="w-5 h-5 text-gray-400 absolute left-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    <form method="GET" action="{{ route('admin.pengguna') }}" class="w-full">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengguna..." class="w-full bg-gray-100/50 border border-transparent focus:border-gray-200 hover:bg-gray-100 rounded-full pl-12 pr-4 py-2.5 text-sm outline-none transition-all placeholder-gray-400 text-dark">
    </form>
</div>
@endsection

<!-- Page Title & Action -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-dark mb-1">Kelola Pengguna</h1>
        <p class="text-gray-500">Total {{ count($penggunaList ?? []) }} pengguna terdaftar.</p>
    </div>
    <button onclick="document.getElementById('modalForm').classList.remove('hidden')" class="px-5 py-2.5 bg-accent text-white rounded-xl text-sm font-bold shadow-md hover:bg-orange-700 transition-colors flex items-center gap-2 cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Pengguna
    </button>
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
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ $err }}
    </div>
    @endforeach
</div>
@endif

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center h-64 hover:shadow-md transition-shadow">
        <h4 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-wider w-full text-left">Persebaran Role</h4>
        <div class="h-full w-full relative flex justify-center">
            <div class="w-full max-w-sm h-full relative">
                <canvas id="roleChart"></canvas>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center h-64 hover:shadow-md transition-shadow">
        <h4 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-wider w-full text-left">Top 5 Kabupaten</h4>
        <div class="h-full w-full relative">
            <canvas id="kotaChart"></canvas>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="mb-6">
    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('admin.pengguna') }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ ($activeRole ?? 'Semua') === 'Semua' ? 'bg-dark text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 hover:shadow-sm' }}">Semua</a>
        <a href="{{ route('admin.pengguna', ['role' => 'Klien']) }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ ($activeRole ?? '') === 'Klien' ? 'bg-dark text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 hover:shadow-sm' }}">User</a>
        <a href="{{ route('admin.pengguna', ['role' => 'Freelancer']) }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all {{ ($activeRole ?? '') === 'Freelancer' ? 'bg-dark text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 hover:shadow-sm' }}">Freelancer</a>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
        <thead>
            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
            <th class="p-4 pl-6 font-semibold">ID</th>
            <th class="p-4 font-semibold">Nama</th>
            <th class="p-4 font-semibold">Username</th>
            <th class="p-4 font-semibold">Email</th>
            <th class="p-4 font-semibold">No. Telp</th>
            <th class="p-4 font-semibold">Role</th>
            <th class="p-4 font-semibold pr-6 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($penggunaList ?? [] as $pg)
            <tr class="hover:bg-gray-50/50 transition-colors">
            <td class="p-4 pl-6 text-sm text-gray-500">{{ $pg['id_pengguna'] }}</td>
            <td class="p-4">
                <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">{{ substr($pg['nama_pengguna'], 0, 1) }}</div>
                <p class="font-bold text-dark text-sm whitespace-nowrap">{{ $pg['nama_pengguna'] }}</p>
                </div>
            </td>
            <td class="p-4 text-sm text-gray-600">{{ $pg['username'] ?? '-' }}</td>
            <td class="p-4 text-sm text-gray-600">{{ $pg['email'] }}</td>
            <td class="p-4 text-sm text-gray-500">{{ $pg['no_telp'] ?? '-' }}</td>
            <td class="p-4">
                @php
                $roleBadge = 'bg-gray-100 text-gray-600 border-gray-200';
                if (($pg['role'] ?? '') == 'User') $roleBadge = 'bg-blue-50 text-blue-600 border-blue-200';
                if (($pg['role'] ?? '') == 'Freelancer') $roleBadge = 'bg-green-50 text-green-600 border-green-200';
                @endphp
                <span class="px-3 py-1 {{ $roleBadge }} rounded-full text-[11px] font-bold border inline-block">{{ $pg['role'] ?? '-' }}</span>
            </td>
            <td class="p-4 pr-6 text-right">
                <div class="flex items-center justify-end gap-2">
                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail" onclick="openDetailModal({{ json_encode($pg) }})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit" onclick="openEditModal({{ json_encode($pg) }})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <form method="POST" action="{{ route('admin.pengguna.destroy', $pg['id_pengguna']) }}" class="inline-block" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus pengguna ini? Semua jasanya juga akan terhapus.');">
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
            <tr><td colspan="6" class="p-8 text-center text-gray-400">Tidak ada data pengguna.</td></tr>
            @endforelse
        </tbody>
        </table>
    </div>
</div>

<!-- Modal Form Tambah/Edit -->
<div id="modalForm" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all duration-300">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="modalFormContent">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Tambah Pengguna Baru</h3>
    <button onclick="closeModal('modalForm')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    </div>
    <form method="POST" action="{{ route('admin.pengguna.store') }}" class="p-6 space-y-4">
    @csrf
    <div class="grid grid-cols-2 gap-4">
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Username <span class="text-red-500">*</span></label>
        <input type="text" name="username" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Role <span class="text-red-500">*</span></label>
        <select name="id_role" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
            <option value="2" selected>User</option>
            <option value="3">Freelancer</option>
        </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
        <input type="text" name="nama_pengguna" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Email <span class="text-red-500">*</span></label>
        <input type="email" name="email" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">No. Telepon</label>
        <input type="text" name="no_telp" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Password <span class="text-red-500">*</span></label>
        <input type="password" name="password" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
    </div>

    <div class="flex gap-3 pt-4">
        <button type="button" onclick="closeModal('modalForm')" class="flex-1 py-2.5 text-center text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-xl border border-gray-200 transition-colors">Batal</button>
        <button type="submit" class="flex-1 py-2.5 bg-accent text-white text-sm font-bold rounded-xl shadow-md hover:bg-orange-700 transition-colors cursor-pointer">Simpan</button>
    </div>
    </form>
</div>
</div>

<!-- Modal Edit Pengguna -->
<div id="modalEdit" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all duration-300">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="modalEditContent">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Edit Pengguna</h3>
    <button onclick="closeModal('modalEdit')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    </div>
    <form id="editForm" method="POST" action="" class="p-6 space-y-4">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-2 gap-4">
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Username <span class="text-red-500">*</span></label>
        <input type="text" id="edit_username" name="username" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Role <span class="text-red-500">*</span></label>
        <select id="edit_id_role" name="id_role" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
            <option value="2">User</option>
            <option value="3">Freelancer</option>
        </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
        <input type="text" id="edit_nama_pengguna" name="nama_pengguna" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Email <span class="text-red-500">*</span></label>
        <input type="email" id="edit_email" name="email" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">No. Telepon</label>
        <input type="text" id="edit_no_telp" name="no_telp" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Tanggal Lahir</label>
        <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium">
        </div>
        <div>
        <label class="block text-sm font-bold text-dark mb-1.5">Password Baru</label>
        <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium" placeholder="Kosongkan jika tidak diubah">
        </div>
    </div>

    <div class="flex gap-3 pt-4">
        <button type="button" onclick="closeModal('modalEdit')" class="flex-1 py-2.5 text-center text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-xl border border-gray-200 transition-colors">Batal</button>
        <button type="submit" class="flex-1 py-2.5 bg-accent text-white text-sm font-bold rounded-xl shadow-md hover:bg-orange-700 transition-colors cursor-pointer">Perbarui</button>
    </div>
    </form>
</div>
</div>

<!-- Modal Detail Pengguna -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all duration-300">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-[500px] max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="modalDetailContent">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-[#1e293b] text-lg" id="detail_title">Detail Pengguna #</h3>
        <button onclick="closeModal('modalDetail')" class="p-2 text-gray-400 hover:text-dark rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <div class="p-6">
        <div class="flex items-center gap-4 mb-6">
            <div id="detail_avatar" class="w-16 h-16 rounded-full bg-[#f1f5f9] text-[#64748b] flex items-center justify-center font-bold text-2xl"></div>
            <div>
                <h4 id="detail_nama_pengguna" class="text-lg font-bold text-[#1e293b]"></h4>
                <p id="detail_username" class="text-sm font-medium text-[#64748b] mb-1"></p>
                <span id="detail_role" class="px-2 py-0.5 bg-[#f1f5f9] text-[#475569] border border-[#e2e8f0] rounded text-[10px] font-bold tracking-wider uppercase"></span>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-y-4 gap-x-4 mb-6">
            <div>
                <p class="text-[11px] text-[#94a3b8] font-bold uppercase tracking-wide mb-1">EMAIL</p>
                <p id="detail_email" class="text-sm font-medium text-[#1e293b]"></p>
            </div>
            <div>
                <p class="text-[11px] text-[#94a3b8] font-bold uppercase tracking-wide mb-1">NO. TELP</p>
                <p id="detail_no_telp" class="text-sm font-medium text-[#1e293b]"></p>
            </div>
            <div>
                <p class="text-[11px] text-[#94a3b8] font-bold uppercase tracking-wide mb-1">TANGGAL LAHIR</p>
                <p id="detail_tanggal_lahir" class="text-sm font-medium text-[#1e293b]"></p>
            </div>
        </div>
        
        <div class="border-t border-gray-100 pt-6">
            <h5 class="text-sm font-bold text-[#64748b] mb-4">Informasi Alamat</h5>
            <div class="grid grid-cols-2 gap-y-4 gap-x-4 mb-4">
                <div>
                    <p class="text-[11px] text-[#94a3b8] font-bold uppercase tracking-wide mb-1">PROVINSI</p>
                    <p id="detail_provinsi" class="text-sm font-medium text-[#1e293b]"></p>
                </div>
                <div>
                    <p class="text-[11px] text-[#94a3b8] font-bold uppercase tracking-wide mb-1">KABUPATEN/KOTA</p>
                    <p id="detail_kabupaten" class="text-sm font-medium text-[#1e293b]"></p>
                </div>
                <div>
                    <p class="text-[11px] text-[#94a3b8] font-bold uppercase tracking-wide mb-1">KECAMATAN</p>
                    <p id="detail_kecamatan" class="text-sm font-medium text-[#1e293b]"></p>
                </div>
                <div>
                    <p class="text-[11px] text-[#94a3b8] font-bold uppercase tracking-wide mb-1">DESA/KELURAHAN</p>
                    <p id="detail_desa" class="text-sm font-medium text-[#1e293b]"></p>
                </div>
            </div>
            <div class="bg-[#f8fafc] p-4 rounded-xl">
                <p class="text-[11px] text-[#94a3b8] font-bold uppercase tracking-wide mb-1">ALAMAT LENGKAP</p>
                <p id="detail_alamat" class="text-sm font-medium text-[#475569]"></p>
            </div>
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

// Add event listener to buttons that open form/edit modal
document.querySelector('button[onclick="document.getElementById(\'modalForm\').classList.remove(\'hidden\')"]').setAttribute('onclick', "openModal('modalForm')");

function openEditModal(user) {
    document.getElementById('edit_username').value = user.username;
    document.getElementById('edit_id_role').value = user.id_role;
    document.getElementById('edit_nama_pengguna').value = user.nama_pengguna;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_no_telp').value = user.no_telp || '';
    document.getElementById('edit_tanggal_lahir').value = user.tanggal_lahir || '';
    
    document.getElementById('editForm').action = "/admin/pengguna/" + user.id_pengguna;
    openModal('modalEdit');
}

function openDetailModal(user) {
    document.getElementById('detail_title').innerText = 'Detail Pengguna #' + user.id_pengguna;
    document.getElementById('detail_avatar').innerText = user.nama_pengguna.substring(0, 1).toUpperCase();
    document.getElementById('detail_nama_pengguna').innerText = user.nama_pengguna;
    document.getElementById('detail_username').innerText = '@' + (user.username || '');
    document.getElementById('detail_role').innerText = user.role || '-';
    document.getElementById('detail_email').innerText = user.email;
    document.getElementById('detail_no_telp').innerText = user.no_telp || '-';
    document.getElementById('detail_tanggal_lahir').innerText = user.tanggal_lahir || '-';
    
    document.getElementById('detail_provinsi').innerText = user.provinsi || '-';
    document.getElementById('detail_kabupaten').innerText = user.kabupaten || '-';
    document.getElementById('detail_kecamatan').innerText = user.kecamatan || '-';
    document.getElementById('detail_desa').innerText = user.desa || '-';
    document.getElementById('detail_alamat').innerText = user.alamat_lengkap || '-';
    
    openModal('modalDetail');
}

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('roleChart');
    if (!ctx) return;
    const rawData = {!! json_encode($chartData ?? []) !!};
    
    const labels = rawData.map(item => item.nama_role);
    const data = rawData.map(item => item.total);
    
    new Chart(ctx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#2196F3', '#4CAF50', '#FF6B00'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: "'Inter', sans-serif" }, usePointStyle: true } }
            },
            cutout: '65%'
        }
    });

    // Kota Chart
    const ctxKota = document.getElementById('kotaChart');
    if (ctxKota) {
        const kotaData = {!! json_encode($kotaChartData ?? []) !!};
        new Chart(ctxKota.getContext('2d'), {
            type: 'bar',
            data: {
                labels: kotaData.map(i => i.kabupaten),
                datasets: [{
                    label: 'Pengguna',
                    data: kotaData.map(i => i.total),
                    backgroundColor: '#9C27B0',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});
</script>

@endsection
