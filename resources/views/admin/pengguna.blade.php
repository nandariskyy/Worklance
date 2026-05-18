@extends('layouts.admin')

@section('title', 'Kelola Pengguna | Admin WorkLance')

@section('content')
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

<!-- Filter Tabs -->
<div class="flex gap-2 mb-6 flex-wrap">
    <a href="{{ route('admin.pengguna') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeRole ?? 'Semua') === 'Semua' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Semua</a>
    <a href="{{ route('admin.pengguna', ['role' => 'Klien']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeRole ?? '') === 'Klien' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Klien</a>
    <a href="{{ route('admin.pengguna', ['role' => 'Freelancer']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeRole ?? '') === 'Freelancer' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Freelancer</a>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
        <thead>
            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
            <th class="p-4 pl-6 font-semibold">ID</th>
            <th class="p-4 font-semibold">Nama</th>
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
            <td class="p-4 text-sm text-gray-600">{{ $pg['email'] }}</td>
            <td class="p-4 text-sm text-gray-500">{{ $pg['no_telp'] ?? '-' }}</td>
            <td class="p-4">
                @php
                $roleBadge = 'bg-gray-100 text-gray-600 border-gray-200';
                if (($pg['role'] ?? '') == 'Klien') $roleBadge = 'bg-blue-50 text-blue-600 border-blue-200';
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
                <form method="POST" action="{{ route('admin.pengguna.destroy', $pg['id_pengguna']) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Semua jasanya juga akan terhapus.');">
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
<div id="modalForm" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Tambah Pengguna Baru</h3>
    <button onclick="document.getElementById('modalForm').classList.add('hidden')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
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
            <option value="1">Admin</option>
            <option value="2" selected>Klien</option>
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
        <button type="button" onclick="document.getElementById('modalForm').classList.add('hidden')" class="flex-1 py-2.5 text-center text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-xl border border-gray-200 transition-colors">Batal</button>
        <button type="submit" class="flex-1 py-2.5 bg-accent text-white text-sm font-bold rounded-xl shadow-md hover:bg-orange-700 transition-colors cursor-pointer">Simpan</button>
    </div>
    </form>
</div>
</div>

<!-- Modal Edit Pengguna -->
<div id="modalEdit" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Edit Pengguna</h3>
    <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
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
            <option value="1">Admin</option>
            <option value="2">Klien</option>
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
        <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="flex-1 py-2.5 text-center text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-xl border border-gray-200 transition-colors">Batal</button>
        <button type="submit" class="flex-1 py-2.5 bg-accent text-white text-sm font-bold rounded-xl shadow-md hover:bg-orange-700 transition-colors cursor-pointer">Perbarui</button>
    </div>
    </form>
</div>
</div>

<!-- Modal Detail Pengguna -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Detail Pengguna</h3>
    <button onclick="document.getElementById('modalDetail').classList.add('hidden')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    </div>
    <div class="p-6">
        <div class="flex items-center gap-4 mb-6">
            <div id="detail_avatar" class="w-16 h-16 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-2xl"></div>
            <div>
                <h4 id="detail_nama_pengguna" class="text-xl font-bold text-dark"></h4>
                <p id="detail_role" class="text-sm font-semibold text-accent"></p>
            </div>
        </div>
        
        <div class="space-y-4">
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">ID Pengguna</p>
                <p id="detail_id" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Username</p>
                <p id="detail_username" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Email</p>
                <p id="detail_email" class="text-sm font-medium text-dark"></p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">No. Telepon</p>
                    <p id="detail_no_telp" class="text-sm font-medium text-dark"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Tanggal Lahir</p>
                    <p id="detail_tanggal_lahir" class="text-sm font-medium text-dark"></p>
                </div>
            </div>
        </div>
        
        <div class="mt-8">
            <button onclick="document.getElementById('modalDetail').classList.add('hidden')" class="w-full py-2.5 bg-gray-100 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-200 transition-colors">Tutup</button>
        </div>
    </div>
</div>
</div>

<script>
function openEditModal(user) {
    document.getElementById('edit_username').value = user.username;
    document.getElementById('edit_id_role').value = user.id_role;
    document.getElementById('edit_nama_pengguna').value = user.nama_pengguna;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_no_telp').value = user.no_telp || '';
    document.getElementById('edit_tanggal_lahir').value = user.tanggal_lahir || '';
    
    document.getElementById('editForm').action = "/admin/pengguna/" + user.id_pengguna;
    document.getElementById('modalEdit').classList.remove('hidden');
}

function openDetailModal(user) {
    document.getElementById('detail_avatar').innerText = user.nama_pengguna.substring(0, 1).toUpperCase();
    document.getElementById('detail_nama_pengguna').innerText = user.nama_pengguna;
    document.getElementById('detail_role').innerText = user.role || '-';
    document.getElementById('detail_id').innerText = user.id_pengguna;
    document.getElementById('detail_username').innerText = user.username;
    document.getElementById('detail_email').innerText = user.email;
    document.getElementById('detail_no_telp').innerText = user.no_telp || '-';
    document.getElementById('detail_tanggal_lahir').innerText = user.tanggal_lahir || '-';
    
    document.getElementById('modalDetail').classList.remove('hidden');
}
</script>

@endsection
