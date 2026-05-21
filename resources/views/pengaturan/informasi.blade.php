@extends('layouts.app')

@section('title', 'Informasi Akun | WorkLance')

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
          <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
          
          <h2 class="text-xl font-bold text-dark mb-6 relative z-10">Informasi Akun</h2>
          
          <form id="hapusFotoForm" method="POST" action="{{ route('pengaturan.informasi.hapus-foto') }}" class="hidden">
            @csrf
          </form>

          <form method="POST" action="{{ route('pengaturan.informasi') }}" enctype="multipart/form-data" class="space-y-5 relative z-10">
            @csrf
            
            <div class="flex items-center gap-6 mb-6">
              <div class="relative group" id="foto_preview_container">
                @if($user->foto_profil)
                  <img id="foto_preview_img" src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                @else
                  <img id="foto_preview_img" src="" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md hidden">
                  <div id="foto_preview_initial" class="w-24 h-24 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-3xl border-4 border-white shadow-md">
                    {{ strtoupper(substr($user->nama_pengguna, 0, 1)) }}
                  </div>
                @endif
              </div>
              <div class="flex-1">
                <label class="text-sm font-bold text-dark block mb-2">Foto Profil</label>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                  <input type="file" id="foto_profil_input" name="foto_profil" accept="image/jpeg, image/png, image/jpg, image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors cursor-pointer">
                  @if($user->foto_profil)
                    <button type="button" onclick="openCustomConfirm('Apakah Anda yakin ingin menghapus foto profil ini?', document.getElementById('hapusFotoForm'))" class="shrink-0 text-sm font-bold text-red-500 bg-red-50 hover:bg-red-100 px-4 py-2.5 rounded-xl transition-colors">Hapus Foto</button>
                  @endif
                </div>
                <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
              </div>
            </div>

            <div>
              <label class="text-sm font-bold text-dark block mb-2">Nama Lengkap</label>
              <input type="text" name="nama_pengguna" value="{{ old('nama_pengguna', $user->nama_pengguna) }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors">
            </div>
            <div>
              <label class="text-sm font-bold text-dark block mb-2">Username</label>
              <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors">
            </div>
            <div>
              <label class="text-sm font-bold text-dark block mb-2">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors">
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
    document.getElementById('foto_profil_input').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          let img = document.getElementById('foto_preview_img');
          let initial = document.getElementById('foto_preview_initial');
          if(img) {
              img.src = event.target.result;
              img.classList.remove('hidden');
          }
          if(initial) {
              initial.classList.add('hidden');
          }
        }
        reader.readAsDataURL(file);
      }
    });
  </script>
@endsection
