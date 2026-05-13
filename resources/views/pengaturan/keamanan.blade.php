@extends('layouts.app')

@section('title', 'Keamanan Akun | WorkLance')

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
      <div class="lg:col-span-3 space-y-8">
        @if (session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          {{ session('error') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm font-medium flex flex-col gap-2 shadow-sm">
          @foreach ($errors->all() as $err)
          <div class="flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ $err }}
          </div>
          @endforeach
        </div>
        @endif

        <!-- Change Password -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 relative overflow-hidden">
          <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
          
          <h2 class="text-xl font-bold text-dark mb-6 relative z-10">Ubah Password</h2>
          <form method="POST" action="{{ route('pengaturan.keamanan.password') }}" class="space-y-5 relative z-10">
            @csrf
            <div>
              <label class="text-sm font-bold text-dark block mb-2">Password Lama</label>
              <input type="password" name="password_lama" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors" placeholder="Masukkan password saat ini">
            </div>
            <div>
              <label class="text-sm font-bold text-dark block mb-2">Password Baru</label>
              <input type="password" name="password_baru" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors" placeholder="Buat password baru">
            </div>
            <div>
              <label class="text-sm font-bold text-dark block mb-2">Konfirmasi Password Baru</label>
              <input type="password" name="konfirmasi_password" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark transition-colors" placeholder="Ulangi password baru">
            </div>
            <button type="submit" class="bg-dark hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all cursor-pointer">Perbarui Password</button>
          </form>
        </div>

        <!-- Delete Account -->
        <div class="bg-white rounded-2xl shadow-sm border border-red-200 p-8">
          <h2 class="text-xl font-bold text-red-600 mb-2">Hapus Akun</h2>
          <p class="text-gray-500 text-sm mb-6">Tindakan ini tidak dapat dibatalkan. Semua data (termasuk pesanan dan jasa Anda) akan dihapus secara permanen.</p>
          <form method="POST" action="{{ route('pengaturan.keamanan.hapus') }}" class="space-y-4">
            @csrf
            <div>
              <label class="text-sm font-bold text-dark block mb-2">Ketik <span class="text-red-600">HAPUS</span> untuk konfirmasi</label>
              <input type="text" name="konfirmasi_hapus" required class="w-full border border-red-200 rounded-xl px-4 py-3 bg-red-50/50 focus:outline-none focus:ring-2 focus:ring-red-400 text-sm font-medium text-dark transition-colors" placeholder="HAPUS">
            </div>
            <button type="submit" onclick="return confirm('Apakah Anda sangat yakin ingin menghapus akun ini secara permanen?')" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all cursor-pointer">Hapus Akun Saya</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
