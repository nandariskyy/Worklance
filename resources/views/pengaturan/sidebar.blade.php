<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
  <a href="{{ route('pengaturan.informasi') }}" class="flex items-center gap-3 px-5 py-4 text-sm font-bold transition-colors {{ Request::routeIs('pengaturan.informasi') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'text-gray-600 hover:bg-gray-50' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
    Informasi Akun
  </a>
  <a href="{{ route('pengaturan.kontak') }}" class="flex items-center gap-3 px-5 py-4 text-sm font-bold transition-colors {{ Request::routeIs('pengaturan.kontak') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'text-gray-600 hover:bg-gray-50' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
    Kontak & Alamat
  </a>
  <a href="{{ route('pengaturan.keamanan') }}" class="flex items-center gap-3 px-5 py-4 text-sm font-bold transition-colors {{ Request::routeIs('pengaturan.keamanan') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'text-gray-600 hover:bg-gray-50' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
    Keamanan
  </a>
  <div class="border-t border-gray-100"></div>
  <form method="POST" action="{{ route('logout') }}" class="w-full">
    @csrf
    <button type="submit" class="w-full flex items-center gap-3 px-5 py-4 text-sm font-bold text-red-500 hover:bg-red-50 transition-colors cursor-pointer text-left">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
      Logout
    </button>
  </form>
</div>
