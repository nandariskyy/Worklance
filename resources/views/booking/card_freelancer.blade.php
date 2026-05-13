<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-6 items-start hover:shadow-md transition-all {{ !$isActive ? 'opacity-75 hover:opacity-100' : '' }}">
  <div class="flex-grow">
    <div class="flex items-center gap-3 mb-2">
      @if ($p['status_booking'] == 'MENUNGGU')
        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-yellow-100 text-yellow-700 rounded-md">MENUNGGU KONFIRMASI</span>
      @elseif ($p['status_booking'] == 'DIPROSES')
        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-700 rounded-md">DIPROSES</span>
      @elseif ($p['status_booking'] == 'SELESAI')
        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700 rounded-md">SELESAI</span>
      @else
        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-700 rounded-md">{{ $p['status_booking'] }}</span>
      @endif
      <span class="text-xs font-semibold text-gray-400">{{ date('d M Y', strtotime($p['tanggal_booking'])) }}</span>
    </div>
    
    <h2 class="text-xl font-bold text-dark mb-1">{{ $p['nama_jasa'] }}</h2>
    <p class="text-sm font-medium text-accent mb-4">{{ $p['nama_kategori'] }}</p>
    
    <div class="text-sm text-gray-600 space-y-1 mb-4">
      <p><strong>Klien:</strong> {{ $p['nama_klien'] }} ({{ $p['no_telp_klien'] }})</p>
      <p><strong>Alamat:</strong> {{ $p['alamat_booking'] }}</p>
      <p><strong>Catatan:</strong> {{ $p['catatan'] ?: '-' }}</p>
      <p><strong>Tarif:</strong> Rp {{ number_format($p['tarif'], 0, ',', '.') }} / {{ $p['nama_satuan'] }}</p>
    </div>

    @if (!$isActive && isset($p['rating']))
    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 inline-block mt-2">
      <div class="flex items-center gap-1 text-yellow-400 mb-1">
        @for ($i=1; $i<=5; $i++)
          <svg class="w-4 h-4 {{ $i <= $p['rating'] ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
        @endfor
      </div>
      <p class="text-xs text-gray-500 italic">"{{ $p['komentar'] }}"</p>
    </div>
    @endif
  </div>

  <div class="flex flex-col gap-2 min-w-[150px]">
    @if ($p['status_booking'] == 'MENUNGGU')
      <form method="POST" action="{{ route('booking.status') }}" onsubmit="return confirm('Terima pesanan ini?');">
        @csrf
        <input type="hidden" name="id_booking" value="{{ $p['id_booking'] }}">
        <input type="hidden" name="status" value="DIPROSES">
        <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white hover:bg-green-600 rounded-lg text-sm font-bold transition-colors shadow-sm">Terima & Proses</button>
      </form>
      <form method="POST" action="{{ route('booking.status') }}" onsubmit="return confirm('Yakin ingin menolak pesanan ini?');">
        @csrf
        <input type="hidden" name="id_booking" value="{{ $p['id_booking'] }}">
        <input type="hidden" name="status" value="DITOLAK">
        <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-sm font-bold transition-colors">Tolak</button>
      </form>
    @elseif ($p['status_booking'] == 'DIPROSES')
      <form method="POST" action="{{ route('booking.status') }}" onsubmit="return confirm('Pekerjaan sudah selesai sepenuhnya?');">
        @csrf
        <input type="hidden" name="id_booking" value="{{ $p['id_booking'] }}">
        <input type="hidden" name="status" value="SELESAI">
        <button type="submit" class="w-full px-4 py-2 bg-accent text-white hover:bg-orange-600 rounded-lg text-sm font-bold transition-colors shadow-sm">Selesaikan</button>
      </form>
    @endif
  </div>
</div>
