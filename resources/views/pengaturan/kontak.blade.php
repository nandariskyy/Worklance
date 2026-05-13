@extends('layouts.app')

@section('title', 'Kontak & Alamat | WorkLance')

@section('content')
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow w-full">
    <h1 class="text-3xl font-bold text-dark mb-2">Pengaturan Akun</h1>
    <p class="text-gray-500 mb-8">Kelola informasi profil dan keamanan akun Anda.</p>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Sidebar -->
      <div class="lg:col-span-1">
        @include('pengaturan.sidebar')
      </div>

      <!-- Content -->
      <div class="lg:col-span-3">
        @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          {{ session('success') }}
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

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 relative overflow-hidden">
          <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
          
          <h2 class="text-xl font-bold text-dark mb-6 relative z-10">Kontak & Alamat</h2>
          
          <form method="POST" action="{{ route('pengaturan.kontak') }}" class="space-y-5 relative z-10">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="text-sm font-bold text-dark block mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors">
              </div>
              <div>
                <label class="text-sm font-bold text-dark block mb-2">No. Telepon</label>
                <input type="tel" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors">
              </div>
            </div>

            <hr class="border-gray-100 my-4">
            <h3 class="text-lg font-bold text-dark">Alamat</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="text-sm font-bold text-dark block mb-2">Provinsi</label>
                <select name="id_provinsi" id="selProvinsi" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors">
                  <option value="">-- Pilih --</option>
                  @foreach ($provinsiList as $p)
                  <option value="{{ $p->id_provinsi }}" {{ old('id_provinsi', $user->id_provinsi) == $p->id_provinsi ? 'selected' : '' }}>{{ $p->nama_provinsi }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="text-sm font-bold text-dark block mb-2">Kabupaten/Kota</label>
                <select name="id_kabupaten" id="selKabupaten" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors">
                  <option value="">-- Pilih --</option>
                  @foreach ($kabupatenList as $k)
                  <option value="{{ $k->id_kabupaten }}" data-prov="{{ $k->id_provinsi }}" {{ old('id_kabupaten', $user->id_kabupaten) == $k->id_kabupaten ? 'selected' : '' }}>{{ $k->nama_kabupaten }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="text-sm font-bold text-dark block mb-2">Kecamatan</label>
                <select name="id_kecamatan" id="selKecamatan" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors">
                  <option value="">-- Pilih --</option>
                  @foreach ($kecamatanList as $kc)
                  <option value="{{ $kc->id_kecamatan }}" data-kab="{{ $kc->id_kabupaten }}" {{ old('id_kecamatan', $user->id_kecamatan) == $kc->id_kecamatan ? 'selected' : '' }}>{{ $kc->nama_kecamatan }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="text-sm font-bold text-dark block mb-2">Desa/Kelurahan</label>
                <select name="id_desa" id="selDesa" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors">
                  <option value="">-- Pilih --</option>
                  @foreach ($desaList as $d)
                  <option value="{{ $d->id_desa }}" data-kec="{{ $d->id_kecamatan }}" {{ old('id_desa', $user->id_desa) == $d->id_desa ? 'selected' : '' }}>{{ $d->nama_desa }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div>
              <label class="text-sm font-bold text-dark block mb-2">Alamat Lengkap</label>
              <textarea name="alamat_lengkap" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark resize-none transition-colors">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
            </div>

            <div class="pt-2">
              <button type="submit" class="bg-accent hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all cursor-pointer">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        function cascadeFilter(parentSel, childSel, dataAttr) {
            const parent = document.getElementById(parentSel);
            const child = document.getElementById(childSel);
            
            if (!parent || !child) return;

            // Trigger change logic
            function updateChild() {
                const val = parent.value;
                let hasValidOption = false;
                
                Array.from(child.options).forEach(opt => {
                    if (opt.value === "") return; // Skip placeholder
                    const match = (!val || opt.getAttribute(dataAttr) === val);
                    opt.style.display = match ? '' : 'none';
                    if (match && opt.selected) hasValidOption = true;
                });
                
                if (!hasValidOption && child.value !== "") {
                    child.value = "";
                }
                
                // Dispatch event so the next child updates too
                child.dispatchEvent(new Event('change'));
            }

            parent.addEventListener('change', updateChild);
            
            // Run on load
            updateChild();
        }
        
        cascadeFilter('selProvinsi', 'selKabupaten', 'data-prov');
        cascadeFilter('selKabupaten', 'selKecamatan', 'data-kab');
        cascadeFilter('selKecamatan', 'selDesa', 'data-kec');
    });
  </script>
@endsection
