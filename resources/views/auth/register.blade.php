<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar | WorkLance</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans py-10">
  <div class="w-full max-w-xl p-8 bg-white rounded-3xl shadow-xl shadow-primary/10 border border-gray-100 m-4">
    <div class="text-center mb-8">
      <a href="{{ url('/') }}" class="inline-flex items-center gap-2 group mb-6">
        <div class="w-10 h-10 bg-dark text-white rounded-xl flex items-center justify-center font-bold text-xl shadow-md">W</div>
        <span class="text-2xl font-bold text-dark tracking-tight">Work<span class="text-accent">Lance</span></span>
      </a>
      <h2 class="text-2xl font-bold text-dark">Gabung Bersama Kami</h2>
      <p class="text-gray-500 mt-2">Buat akun WorkLance Anda untuk mulai mencari jasa atau mendaftar sebagai freelancer lokal.</p>
    </div>

    @if ($error)
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm font-medium flex items-center gap-2">
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      {{ $error }}
    </div>
    @endif

    <form method="POST" action="" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-bold text-dark mb-2">Email</label>
        <input type="email" name="email" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors" placeholder="nama@email.com" required>
      </div>
      <div>
        <label class="block text-sm font-bold text-dark mb-2">Username</label>
        <input type="text" name="username" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors" placeholder="budisantoso" required>
      </div>
      <div>
        <label class="block text-sm font-bold text-dark mb-2">No Telp</label>
        <input type="tel" name="no_telp" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors" placeholder="081234567890">
      </div>
      <div>
        <label class="block text-sm font-bold text-dark mb-2">Password</label>
        <input type="password" name="password" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-colors" placeholder="Buat password yang kuat" required>
      </div>
      <button type="submit" class="w-full bg-accent hover:bg-orange-600 text-white font-bold py-3.5 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 mt-4 text-lg cursor-pointer">
        Buat Akun
      </button>
    </form>
    <p class="text-center text-gray-600 mt-8 text-sm">
      Sudah punya akun? <a href="{{ route('login') }}" class="text-dark font-bold hover:underline">Masuk di sini</a>
    </p>
  </div>
</body>
</html>
