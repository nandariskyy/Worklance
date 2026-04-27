@extends('layouts.app')

@section('title', 'Pendaftaran Freelancer | WorkLance')

@section('content')
  <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
      <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-dark p-8 md:p-10 text-white relative overflow-hidden">
          <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
          <div class="absolute bottom-0 left-0 w-48 h-48 bg-accent/15 rounded-full blur-3xl translate-y-1/2 -translate-x-1/3"></div>
          <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">Form Pengajuan Freelancer</h1>
            <p class="text-gray-300">Bergabunglah dan mulai tawarkan keahlian Anda kepada klien di sekitar Anda.</p>
          </div>
        </div>

        <form method="POST" action="" class="p-8 md:p-10 space-y-8">
          @csrf
          <!-- Section 1: Identitas Diri -->
          <div>
            <h2 class="text-xl font-bold text-dark mb-1 flex items-center gap-2">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
              Identitas Diri
            </h2>
            <p class="text-sm text-gray-500 mb-5">Informasi dasar akun Anda. (Dapat diubah di Pengaturan Akun)</p>
            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-bold text-dark mb-2">Nama Lengkap</label>
                <input type="text" value="Budi Santoso" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-100 focus:outline-none text-sm font-medium text-gray-500 cursor-not-allowed" readonly>
              </div>
              <div>
                <label class="block text-sm font-bold text-dark mb-2">Email</label>
                <input type="email" value="budi@example.com" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-100 focus:outline-none text-sm font-medium text-gray-500 cursor-not-allowed" readonly>
              </div>
              <div>
                <label class="block text-sm font-bold text-dark mb-2">Provinsi <span class="text-red-500">*</span></label>
                <select name="id_provinsi" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark cursor-pointer">
                  <option value="">-- Pilih --</option>
                  <option value="1">Jawa Barat</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-bold text-dark mb-2">Kabupaten/Kota <span class="text-red-500">*</span></label>
                <select name="id_kabupaten" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark cursor-pointer">
                  <option value="">-- Pilih --</option>
                  <option value="1">Bandung</option>
                </select>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-bold text-dark mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea name="alamat_lengkap" rows="2" required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark resize-none cursor-text">Jl. Contoh No. 123</textarea>
              </div>
            </div>
          </div>

          <hr class="border-gray-100">

          <!-- Section 2: Data Pengajuan -->
          <div>
            <h2 class="text-xl font-bold text-dark mb-1 flex items-center gap-2">
              <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
              Data Pengajuan
            </h2>
            <p class="text-sm text-gray-500 mb-5">Lengkapi data tambahan untuk verifikasi keamanan dan keahlian Anda.</p>
            <div class="space-y-6">
              <div>
                <label class="block text-sm font-bold text-dark mb-2">Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span></label>
                <input type="text" name="nik" placeholder="Ketik 16 digit NIK Anda..." required maxlength="16" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark">
                <p class="text-xs text-gray-400 mt-1">Hanya digunakan untuk verifikasi identitas internal.</p>
              </div>
              
              <div>
                <label class="block text-sm font-bold text-dark mb-2">Deskripsi Diri & Keahlian <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="5" placeholder="Ceritakan riwayat pendidikan, pengalaman kerja, alur kerja, hingga pencapaian relevan yang membuat Anda layak menjadi freelancer di platform ini..." required class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white text-sm font-medium text-dark resize-none"></textarea>
              </div>
            </div>
          </div>

          <!-- Agreement -->
          <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
            <input type="checkbox" id="agree" name="agree" required class="mt-1 w-4 h-4 accent-accent cursor-pointer">
            <label for="agree" class="text-sm text-gray-600 cursor-pointer">
              Dengan mengajukan permohonan ini, saya menyatakan bahwa data yang saya berikan adalah benar. Saya menyetujui <a href="#" class="text-accent font-bold hover:underline">Syarat & Ketentuan</a> untuk menjadi freelancer dan siap menjaga nama baik platform.
            </label>
          </div>

          <!-- Action Buttons -->
          <div class="pt-4 flex flex-col sm:flex-row items-center gap-4">
            <a href="{{ route('freelancer.mulai') }}" class="px-8 py-3.5 text-gray-600 font-bold hover:text-dark transition-colors text-center w-full sm:w-auto">Kembali</a>
            <button type="submit" class="flex-1 w-full sm:w-auto bg-accent hover:bg-orange-600 text-white font-bold py-3.5 rounded-xl shadow-[0_8px_20px_-6px_rgba(193,87,42,0.5)] hover:shadow-xl transition-all transform hover:-translate-y-0.5 text-lg cursor-pointer">
              Kirim Pengajuan
            </button>
          </div>
        </form>
      </div>

    </div>
  </main>
@endsection
