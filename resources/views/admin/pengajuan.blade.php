@extends('layouts.admin')

@section('title', 'Verifikasi Pengajuan | Admin WorkLance')

@section('content')
@section('header_content')
<div class="hidden sm:flex flex-1 max-w-lg items-center relative">
    <svg class="w-5 h-5 text-gray-400 absolute left-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    <form method="GET" action="{{ route('admin.pengajuan') }}" class="w-full">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama freelancer..." class="w-full bg-gray-100/50 border border-transparent focus:border-gray-200 hover:bg-gray-100 rounded-full pl-12 pr-4 py-2.5 text-sm outline-none transition-all placeholder-gray-400 text-dark">
    </form>
</div>
@endsection
<!-- Page Title & Action -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-dark mb-1">Verifikasi Pendaftaran Freelancer</h1>
        <p class="text-gray-500">Total {{ count($pengajuanList ?? []) }} pengajuan telah diinput masuk.</p>
    </div>
</div>

<!-- Filter Tabs -->
<div class="flex gap-2 mb-6 flex-wrap">
    <a href="{{ route('admin.pengajuan') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeStatus ?? 'Semua') === 'Semua' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Semua</a>
    <a href="{{ route('admin.pengajuan', ['status' => 'MENUNGGU']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeStatus ?? '') === 'MENUNGGU' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Menunggu</a>
    <a href="{{ route('admin.pengajuan', ['status' => 'DITERIMA']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeStatus ?? '') === 'DITERIMA' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Diterima</a>
    <a href="{{ route('admin.pengajuan', ['status' => 'DITOLAK']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ ($activeStatus ?? '') === 'DITOLAK' ? 'bg-dark text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Ditolak</a>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
        <thead>
            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
            <th class="p-4 pl-6 font-semibold">Tanggal</th>
            <th class="p-4 font-semibold">Nama Pengguna</th>
            <th class="p-4 font-semibold">Kontak</th>
            <th class="p-4 font-semibold">NIK</th>
            <th class="p-4 font-semibold">Status</th>
            <th class="p-4 font-semibold pr-6 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($pengajuanList ?? [] as $pj)
            <tr class="hover:bg-gray-50/50 transition-colors">
            <td class="p-4 pl-6 text-sm text-gray-500 whitespace-nowrap">
                {{ date('d-m-Y', strtotime($pj['tanggal_pengajuan'])) }}
            </td>
            <td class="p-4">
                <div class="font-bold text-dark text-sm">{{ $pj['nama_pengguna'] }}</div>
            </td>
            <td class="p-4">
                <p class="text-sm font-medium text-dark">{{ $pj['email'] ?? '-' }}</p>
                <p class="text-xs text-gray-500">{{ $pj['no_telp'] ?? '-' }}</p>
            </td>
            <td class="p-4 text-sm text-gray-600">
                {{ $pj['nik'] ?? '-' }}
            </td>
            <td class="p-4">
                @if (($pj['status'] ?? '') === 'MENUNGGU')
                <span class="px-2.5 py-1 bg-yellow-50 text-yellow-600 border border-yellow-200 rounded-md text-[11px] font-bold tracking-wide">MENUNGGU</span>
                @elseif (($pj['status'] ?? '') === 'DITERIMA')
                <span class="px-2.5 py-1 bg-green-50 text-green-600 border border-green-200 rounded-md text-[11px] font-bold tracking-wide">DITERIMA</span>
                @else
                <span class="px-2.5 py-1 bg-red-50 text-red-600 border border-red-200 rounded-md text-[11px] font-bold tracking-wide">DITOLAK</span>
                @endif
            </td>
            <td class="p-4 pr-6 text-right">
                <div class="flex items-center justify-end gap-2">
                @if (($pj['status'] ?? '') === 'MENUNGGU')
                    <form method="POST" action="{{ route('admin.pengajuan.verifikasi') }}" class="inline-block" onsubmit="return confirmAction(event, 'Yakin menyetujui pengajuan ini?');">
                        @csrf
                        <input type="hidden" name="id_pengajuan" value="{{ $pj['id_pengajuan'] }}">
                        <input type="hidden" name="action" value="approve">
                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors cursor-pointer" title="Terima">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.pengajuan.verifikasi') }}" class="inline-block" onsubmit="return confirmAction(event, 'Yakin menolak pengajuan ini?');">
                        @csrf
                        <input type="hidden" name="id_pengajuan" value="{{ $pj['id_pengajuan'] }}">
                        <input type="hidden" name="action" value="reject">
                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer" title="Tolak">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </form>
                @endif
                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail" onclick="openDetailModal({{ json_encode($pj) }})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
                </div>
            </td>
            </tr>
            @empty
            <tr><td colspan="5" class="p-8 text-center text-gray-400">Belum ada data pengajuan freelancer.</td></tr>
            @endforelse
        </tbody>
        </table>
    </div>
</div>
</div>

<!-- Modal Detail Pengajuan -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all duration-300">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="modalDetailContent">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-dark text-lg">Detail Pengajuan Verifikasi</h3>
        <button onclick="closeModal('modalDetail')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-2 gap-y-5 gap-x-4 mb-6">
            <div>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mb-1">NAMA PENGGUNA</p>
                <p id="detail_nama" class="text-sm font-bold text-dark"></p>
            </div>
            <div>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mb-1">STATUS PENDAFTARAN</p>
                <span id="detail_status" class="px-2 py-0.5 rounded text-[11px] font-bold tracking-wide border inline-block uppercase mt-0.5"></span>
            </div>
            <div>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mb-1">NIK</p>
                <p id="detail_nik" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mb-1">EMAIL</p>
                <p id="detail_email" class="text-sm font-medium text-gray-600"></p>
            </div>
            <div>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mb-1">NO. TELP</p>
                <p id="detail_telp" class="text-sm font-medium text-gray-600"></p>
            </div>
            <div>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mb-1">WAKTU</p>
                <p id="detail_waktu" class="text-sm font-medium text-gray-600"></p>
            </div>
        </div>
        
        <div class="mb-6">
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mb-2">DESKRIPSI KEAHLIAN</p>
            <div id="detail_deskripsi" class="text-sm font-medium text-gray-700 bg-gray-50/50 p-3 rounded-xl border border-gray-100 min-h-[60px]"></div>
        </div>
        
        <form id="verifikasiForm" method="POST" action="{{ route('admin.pengajuan.verifikasi') }}">
            @csrf
            <input type="hidden" name="id_pengajuan" id="form_id_pengajuan">
            <input type="hidden" name="action" id="form_action">
            
            <div id="action_container" class="border-t border-gray-100 pt-6">
                <label class="block text-sm font-bold text-dark mb-2">Catatan Verifikasi (Opsional)</label>
                <textarea name="catatan" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm text-dark font-medium resize-none mb-4" placeholder="Masukkan alasan ditolak atau catatan tambahan jika diterima..."></textarea>
                
                <div class="flex gap-3">
                    <button type="button" onclick="submitVerifikasi('reject')" class="flex-1 py-3 bg-red-50 text-red-600 border border-red-100 text-sm font-bold rounded-xl hover:bg-red-100 transition-colors">Tolak</button>
                    <button type="button" onclick="submitVerifikasi('approve')" class="flex-1 py-3 bg-green-500 text-white text-sm font-bold rounded-xl shadow-md hover:bg-green-600 transition-colors cursor-pointer">Terima (Jadikan Freelancer)</button>
                </div>
            </div>
        </form>
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

function openDetailModal(pj) {
    document.getElementById('detail_nama').innerText = pj.nama_pengguna;
    document.getElementById('detail_nik').innerText = pj.nik || '-';
    document.getElementById('detail_telp').innerText = pj.no_telp || '-';
    document.getElementById('detail_email').innerText = pj.email || '-';
    
    // Formatting date loosely for display
    const dateObj = new Date(pj.tanggal_pengajuan);
    const day = String(dateObj.getDate()).padStart(2, '0');
    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
    const year = dateObj.getFullYear();
    document.getElementById('detail_waktu').innerText = `${day}-${month}-${year}`;
    
    document.getElementById('detail_deskripsi').innerText = pj.deskripsi_keahlian || pj.surat_lamaran || '';
    
    const statusSpan = document.getElementById('detail_status');
    statusSpan.innerText = pj.status;
    
    statusSpan.className = "px-2 py-0.5 rounded text-[11px] font-bold tracking-wide border inline-block uppercase mt-0.5 ";
    if (pj.status === 'MENUNGGU') statusSpan.className += "bg-yellow-50 text-yellow-600 border-yellow-200";
    if (pj.status === 'DITERIMA') statusSpan.className += "bg-green-50 text-green-600 border-green-200";
    if (pj.status === 'DITOLAK') statusSpan.className += "bg-red-50 text-red-600 border-red-200";
    
    if (pj.status === 'MENUNGGU') {
        document.getElementById('action_container').classList.remove('hidden');
        document.getElementById('form_id_pengajuan').value = pj.id_pengajuan;
    } else {
        document.getElementById('action_container').classList.add('hidden');
    }
    
    openModal('modalDetail');
}

function submitVerifikasi(action) {
    document.getElementById('form_action').value = action;
    const actionText = action === 'approve' ? 'menerima' : 'menolak';
    if(confirm('Yakin ' + actionText + ' pengajuan ini?')) {
        document.getElementById('verifikasiForm').submit();
    }
}
</script>

@endsection
