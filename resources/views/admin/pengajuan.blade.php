@extends('layouts.admin')

@section('title', 'Verifikasi Pengajuan | Admin WorkLance')

@section('content')
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
            <th class="p-4 font-semibold">Kategori Diajukan</th>
            <th class="p-4 font-semibold">Status</th>
            <th class="p-4 font-semibold pr-6 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($pengajuanList ?? [] as $pj)
            <tr class="hover:bg-gray-50/50 transition-colors">
            <td class="p-4 pl-6 text-sm text-gray-500 whitespace-nowrap">
                {{ $pj['tanggal_pengajuan'] }}
            </td>
            <td class="p-4">
                <div class="font-bold text-dark text-sm">{{ $pj['nama_pengguna'] }}</div>
            </td>
            <td class="p-4 text-sm font-medium text-dark whitespace-nowrap">
                {{ $pj['kategori_diajukan'] ?? '-' }}
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
                    <form method="POST" action="{{ route('admin.pengajuan.verifikasi') }}" class="inline-block" onsubmit="return confirm('Yakin menyetujui pengajuan ini?');">
                        @csrf
                        <input type="hidden" name="id_pengajuan" value="{{ $pj['id_pengajuan'] }}">
                        <input type="hidden" name="action" value="approve">
                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors cursor-pointer" title="Terima">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.pengajuan.verifikasi') }}" class="inline-block" onsubmit="return confirm('Yakin menolak pengajuan ini?');">
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
<div id="modalDetail" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-dark text-lg">Detail Pengajuan</h3>
    <button onclick="document.getElementById('modalDetail').classList.add('hidden')" class="p-2 text-gray-400 hover:text-dark hover:bg-gray-100 rounded-lg transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    </div>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Tanggal</p>
                <h4 id="detail_tanggal" class="text-xl font-bold text-dark"></h4>
            </div>
            <div>
                <span id="detail_status" class="px-3 py-1 bg-gray-100 text-gray-600 border border-gray-200 rounded-full text-[11px] font-bold inline-block"></span>
            </div>
        </div>
        
        <div class="space-y-4">
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Nama Pengguna</p>
                <p id="detail_nama" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Kontak</p>
                <p id="detail_kontak" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Kategori Diajukan</p>
                <p id="detail_kategori" class="text-sm font-medium text-dark"></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Surat Lamaran / Keterangan</p>
                <p id="detail_surat" class="text-sm font-medium text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-100"></p>
            </div>
        </div>
        
        <div class="mt-8">
            <button onclick="document.getElementById('modalDetail').classList.add('hidden')" class="w-full py-2.5 bg-gray-100 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-200 transition-colors">Tutup</button>
        </div>
    </div>
</div>
</div>

<script>
function openDetailModal(pj) {
    document.getElementById('detail_tanggal').innerText = pj.tanggal_pengajuan;
    document.getElementById('detail_nama').innerText = pj.nama_pengguna;
    document.getElementById('detail_kontak').innerText = (pj.email || '-') + ' / ' + (pj.no_telp || '-');
    document.getElementById('detail_kategori').innerText = pj.kategori_diajukan || '-';
    document.getElementById('detail_surat').innerText = pj.surat_lamaran || 'Tidak ada keterangan.';
    
    const statusSpan = document.getElementById('detail_status');
    statusSpan.innerText = pj.status;
    
    // reset classes
    statusSpan.className = "px-3 py-1 rounded-full text-[11px] font-bold border inline-block ";
    if (pj.status === 'MENUNGGU') statusSpan.className += "bg-yellow-50 text-yellow-600 border-yellow-200";
    if (pj.status === 'DITERIMA') statusSpan.className += "bg-green-50 text-green-600 border-green-200";
    if (pj.status === 'DITOLAK') statusSpan.className += "bg-red-50 text-red-600 border-red-200";
    
    document.getElementById('modalDetail').classList.remove('hidden');
}
</script>

@endsection
