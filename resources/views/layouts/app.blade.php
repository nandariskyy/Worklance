<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'WorkLance - Temukan Freelancer Lokal Terbaik')</title>
  <meta name="description" content="@yield('description', 'WorkLance adalah platform marketplace freelancer lokal. Temukan tenaga profesional terbaik di sekitarmu dengan mudah, cepat, dan transparan.')" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased overflow-x-hidden">

  <!-- Navbar -->
  @include('components.navbar')

  <!-- Main Content -->
  @yield('content')

  <!-- Footer -->
  @include('components.footer')

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
</body>
</html>
