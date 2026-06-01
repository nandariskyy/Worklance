<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard') | WorkLance</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans text-gray-800 h-screen flex overflow-hidden">

  <!-- Sidebar -->
  <aside class="w-72 bg-dark text-white flex flex-col hidden md:flex flex-shrink-0 z-20">
    <!-- Logo -->
    <div class="h-20 flex items-center px-8 border-b border-white/10 shrink-0">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
        <div class="w-10 h-10 bg-white text-dark rounded-xl flex items-center justify-center font-bold text-xl group-hover:scale-105 transition-transform duration-300 shadow-md">W</div>
        <span class="text-2xl font-bold tracking-tight">Work<span class="text-accent">Lance</span></span>
      </a>
      <span class="ml-2 px-2 py-0.5 text-[10px] font-bold bg-accent rounded-md uppercase tracking-wide">Admin</span>
    </div>

    <!-- Nav Links -->
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5 scrollbar-hide">
      <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Utama</div>
      
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white border border-white/5' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl font-medium transition-colors">
        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
        </svg>
        Dashboard
      </a>
      
      <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.pengguna') ? 'bg-white/10 text-white border border-white/5' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl font-medium transition-colors">
        <svg class="w-5 h-5 {{ request()->routeIs('admin.pengguna') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        Pengguna
      </a>
      
      <a href="{{ route('admin.freelancer') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.freelancer') ? 'bg-white/10 text-white border border-white/5' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl font-medium transition-colors">
        <svg class="w-5 h-5 {{ request()->routeIs('admin.freelancer') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
        Freelancer
      </a>
      
      <a href="{{ route('admin.booking') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.booking') ? 'bg-white/10 text-white border border-white/5' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl font-medium transition-colors">
        <svg class="w-5 h-5 {{ request()->routeIs('admin.booking') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
        </svg>
        Booking
      </a>
      
      <a href="{{ route('admin.pengajuan') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.pengajuan') ? 'bg-white/10 text-white border border-white/5' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl font-medium transition-colors">
        <svg class="w-5 h-5 {{ request()->routeIs('admin.pengajuan') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        Pengajuan
      </a>

      <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-8">Sistem</div>
      
      <a href="{{ route('admin.kelola') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.kelola') ? 'bg-white/10 text-white border border-white/5' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} rounded-xl font-medium transition-colors">
        <svg class="w-5 h-5 {{ request()->routeIs('admin.kelola') ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        Kelola
      </a>
    </div>

    <!-- Bottom Action -->
    <div class="p-4 border-t border-white/10 shrink-0">
      <a href="{{ route('admin.login') }}" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-xl font-medium transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        Logout
      </a>
    </div>
  </aside>

  <!-- Main View -->
  <main class="flex-1 flex flex-col min-w-0 bg-gray-50/50 relative overflow-x-hidden">
    <!-- Abstract Background Decor -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl -z-10 -translate-y-1/2 translate-x-1/2"></div>

    <!-- Top Header -->
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-30 shrink-0">
      <!-- Mobile menu button -->
      <button class="md:hidden p-2 text-gray-500 hover:text-dark hover:bg-gray-100 rounded-xl">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>

      <!-- Dynamic Header Content -->
      @hasSection('header_content')
          @yield('header_content')
      @else
          <!-- Global Search Default -->
          <div class="hidden sm:flex flex-1 max-w-lg items-center relative">
              <svg class="w-5 h-5 text-gray-400 absolute left-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
              <input type="text" placeholder="Cari booking, freelancer, atau pengguna..."
              class="w-full bg-gray-100/50 border border-transparent focus:border-gray-200 hover:bg-gray-100 rounded-full pl-12 pr-4 py-2.5 text-sm outline-none transition-all placeholder-gray-400 text-dark">
          </div>
      @endif

      <!-- Right Nav -->
      <div class="flex items-center gap-3 md:gap-5 ml-auto">
        <!-- Notification -->
        <button class="relative p-2.5 text-gray-500 hover:text-dark hover:bg-gray-100 rounded-full transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
          </svg>
        </button>

        <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>

        <div class="flex items-center gap-3 cursor-pointer group">
          <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm ring-2 ring-gray-100 group-hover:ring-primary transition-all {{ auth()->user()->foto_profil ? '' : 'bg-accent text-white' }}">
            @if(auth()->check() && auth()->user()->foto_profil)
              <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Admin Profile" class="w-10 h-10 rounded-full object-cover">
            @else
              {{ $adminInitials ?? 'A' }}
            @endif
          </div>
          <div class="hidden md:block text-sm">
            <p class="font-bold text-dark leading-tight">{{ $adminNama ?? 'Admin' }}</p>
            <p class="text-gray-500 text-xs font-medium">Super Admin</p>
          </div>
          <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </div>
      </div>
    </header>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto p-6 lg:p-10 pb-20">
        @yield('content')
    </div>
  </main>

  <!-- Global Custom Confirm Modal -->
  <div id="customConfirmModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform transition-all scale-95 opacity-0 duration-200" id="customConfirmModalContent">
      <div class="p-6 text-center">
        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-dark mb-2">Konfirmasi Aksi</h3>
        <p class="text-gray-500 text-sm mb-6 leading-relaxed" id="customConfirmMessage">Apakah Anda yakin ingin melanjutkan?</p>
        <div class="flex gap-3">
          <button type="button" onclick="closeCustomConfirm()" class="flex-1 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
          <button type="button" id="customConfirmBtn" class="flex-1 py-2.5 text-sm font-bold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors shadow-md shadow-red-500/20">Ya, Lanjutkan</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let currentFormToSubmit = null;

    function openCustomConfirm(message, formElement) {
        document.getElementById('customConfirmMessage').innerText = message;
        currentFormToSubmit = formElement;
        
        const modal = document.getElementById('customConfirmModal');
        const content = document.getElementById('customConfirmModalContent');
        
        modal.classList.remove('hidden');
        // trigger animation
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeCustomConfirm() {
        const modal = document.getElementById('customConfirmModal');
        const content = document.getElementById('customConfirmModalContent');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            currentFormToSubmit = null;
        }, 200);
    }

    document.getElementById('customConfirmBtn').addEventListener('click', function() {
        if (currentFormToSubmit) {
            currentFormToSubmit.submit();
        }
    });

    function confirmAction(event, message) {
        event.preventDefault();
        openCustomConfirm(message, event.target);
        return false;
    }
  </script>

</body>
</html>
