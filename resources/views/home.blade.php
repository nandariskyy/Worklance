@extends('layouts.app')

@section('content')

  @if (!empty($search))
  <!-- Search Results -->
  <section class="py-16 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <a href="{{ url('/') }}" class="inline-flex items-center text-gray-500 hover:text-accent font-medium mb-4 transition-colors">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
          Kembali ke Beranda
        </a>
        <h2 class="text-3xl font-bold text-dark mb-2">Hasil Pencarian: "{{ $search }}"</h2>
        <p class="text-gray-500">{{ count($hasilCari ?? []) }} freelancer ditemukan</p>
      </div>
      @if (empty($hasilCari))
      <div class="text-center py-16">
        <p class="text-gray-400 text-lg">Tidak ada freelancer yang cocok dengan pencarian Anda.</p>
      </div>
      @else
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($hasilCari as $idx => $fl)
        <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group hover:-translate-y-1">
          <div class="p-8 relative flex flex-col h-full">
            <div class="absolute top-5 right-5 bg-yellow-50 text-yellow-700 text-sm font-bold px-3 py-1 rounded-full flex items-center border border-yellow-200">
              <svg class="w-4 h-4 mr-1 pb-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
              {{ number_format($fl['avg_rating'], 1) }}
            </div>
            <div class="flex justify-center mb-6 mt-4">
              <div class="w-28 h-28 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-4xl ring-4 ring-primary/20 group-hover:ring-primary/50 transition-all p-1">
                {{ substr($fl['nama_pengguna'], 0, 1) }}
              </div>
            </div>
            <div class="text-center flex-grow">
              <h3 class="text-xl font-bold text-dark mb-1">{{ $fl['nama_pengguna'] }}</h3>
              <p class="text-accent font-medium text-sm mb-4">{{ $fl['nama_jasa'] }}</p>
              <div class="flex items-center justify-center text-gray-500 text-sm mb-6 bg-gray-50 py-1.5 px-3 rounded-full w-max mx-auto">
                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                {{ $fl['alamat_lengkap'] ?? '-' }}
              </div>
            </div>
            <a href="{{ route('layanan.show', $fl['id_layanan'] ?? 1) }}" class="block text-center w-full bg-gray-50 border border-gray-200 text-dark group-hover:bg-dark group-hover:text-white group-hover:border-dark py-3 rounded-xl transition-all duration-300 font-semibold mt-auto">Lihat Profil</a>
          </div>
        </div>
        @endforeach
      </div>
      @endif
    </div>
  </section>
  @else

  <!-- Hero Section -->
  <header class="relative pt-24 pb-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-gray-50 -z-10"></div>
    <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-[800px] h-[800px] bg-primary/20 rounded-full blur-3xl -z-10 opacity-60"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-[600px] h-[600px] bg-accent/10 rounded-full blur-3xl -z-10 opacity-60"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
      <div class="grid lg:grid-cols-2 gap-16 items-center">
        <!-- Hero Text -->
        <div class="max-w-2xl">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white shadow-sm border border-primary/20 text-sm font-medium text-dark mb-6">
            <span class="flex h-2 w-2 rounded-full bg-accent"></span>
            Platform Freelancer Lokal #1
          </div>
          <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-dark leading-[1.1] mb-6 tracking-tight">
            Temukan Freelancer <br />
            <span class="text-accent relative inline-block">
              Lokal Terbaik
              <svg class="absolute w-full h-3 -bottom-1 left-0 text-secondary/30" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" stroke-linecap="round" /></svg>
            </span>
          </h1>
          <p class="text-xl text-gray-600 mb-10 leading-relaxed">
            Hubungkan kebutuhanmu dengan tenaga profesional tepercaya di sekitarmu. Dari desainer, teknisi, hingga tukang bangunan.
          </p>

          <!-- Search Component -->
          <form action="{{ url('/') }}" method="GET" class="bg-white p-3 rounded-2xl shadow-xl shadow-primary/10 border border-gray-100 flex flex-col sm:flex-row gap-3">
            <div class="flex-1 flex items-center px-4 bg-gray-50 rounded-xl">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
              <input type="text" name="search" placeholder="Cari jasa atau keahlian..." class="w-full bg-transparent border-none py-3 px-3 focus:outline-none text-gray-700 placeholder-gray-400">
            </div>
            <button type="submit" class="bg-dark hover:bg-blue-900 text-white px-8 py-3 rounded-xl font-medium transition-colors shadow-md sm:w-auto w-full cursor-pointer">Cari Sekarang</button>
          </form>

          <!-- Popular Tags -->
          <div class="mt-8 flex flex-wrap items-center gap-3 text-sm">
            <span class="text-gray-500 font-medium">Pencarian Populer:</span>
            <a href="?search=Foto" class="px-4 py-1.5 rounded-full bg-white border border-gray-200 text-gray-600 hover:border-accent hover:text-accent transition-colors shadow-sm">Fotografi</a>
            <a href="?search=Service AC" class="px-4 py-1.5 rounded-full bg-white border border-gray-200 text-gray-600 hover:border-accent hover:text-accent transition-colors shadow-sm">Service AC</a>
            <a href="?search=Tukang" class="px-4 py-1.5 rounded-full bg-white border border-gray-200 text-gray-600 hover:border-accent hover:text-accent transition-colors shadow-sm">Tukang Bangunan</a>
          </div>
        </div>

        <!-- Hero Visual -->
        <div class="relative hidden lg:block">
          <div class="relative w-[500px] h-[580px] mx-auto">
            <div class="absolute inset-0 bg-primary rounded-[3rem] rotate-3 opacity-20"></div>
            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=800" alt="Freelancer tersenyum" class="absolute inset-0 w-full h-full object-cover rounded-[3rem] shadow-2xl border-8 border-white">
            <div class="absolute -left-12 top-20 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 border border-gray-100 animate-[bounce_4s_infinite]">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=100" alt="David" class="w-12 h-12 rounded-full object-cover ring-2 ring-primary">
              <div>
                <p class="font-bold text-dark text-sm">David W.</p>
                <div class="flex text-yellow-400 text-xs mt-0.5">★★★★★ <span class="text-gray-500 ml-1">(42)</span></div>
              </div>
            </div>
            <div class="absolute -right-8 bottom-32 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 border border-gray-100 animate-[bounce_5s_infinite_1s]">
              <div class="bg-green-100 p-2.5 rounded-full text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
              <div>
                <p class="font-bold text-dark text-sm">Terverifikasi</p>
                <p class="text-gray-500 text-xs mt-0.5">Identitas & Skill</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Categories Section -->
  <section id="categories" class="py-24 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto mb-16">
        <h2 class="text-4xl font-bold text-dark mb-4">Kategori Keahlian</h2>
        <p class="text-lg text-gray-600">Jelajahi berbagai keahlian dari freelancer lokal, dari desain kreatif hingga<br>perbaikan rumah.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($kategoriList as $kat)
        <a href="?search={{ urlencode($kat['nama_kategori']) }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center group hover:shadow-xl hover:-translate-y-1 hover:border-primary/20 transition-all duration-300 flex flex-col relative overflow-hidden">
          <div class="relative z-10 transition-transform duration-500 group-hover:-translate-y-2">
            <div class="w-14 h-14 mx-auto bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors duration-300">
              <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $kategoriIcons[$kat['id_kategori']] ?? '' !!}</svg>
            </div>
            <h3 class="font-bold text-dark text-sm group-hover:text-accent transition-colors">{{ $kat['nama_kategori'] }}</h3>
          </div>
          @if (!empty($jasaPerKategori[$kat['id_kategori']]))
          <div class="max-h-0 opacity-0 group-hover:max-h-96 group-hover:opacity-100 transition-all duration-500 ease-in-out text-left border-t border-transparent group-hover:border-gray-100 group-hover:mt-4 group-hover:pt-4">
            <ul class="space-y-2.5">
              @foreach ($jasaPerKategori[$kat['id_kategori']] as $j)
              <li class="flex items-start gap-2 text-gray-500 text-xs font-medium">
                <svg class="w-3.5 h-3.5 text-accent mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>{{ $j['nama_jasa'] }}
              </li>
              @endforeach
            </ul>
          </div>
          @endif
        </a>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Featured Freelancers -->
  <section id="freelancers" class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
        <div class="max-w-2xl">
          <h2 class="text-4xl font-bold text-dark mb-4">Freelancer Unggulan</h2>
          <p class="text-lg text-gray-600">Profil profesional dengan rating tertinggi yang siap membantu proyek Anda hari ini.</p>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($freelancerUnggulan as $idx => $fl)
        <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group hover:-translate-y-1">
          <div class="p-8 relative flex flex-col h-full">
            <div class="absolute top-5 right-5 bg-yellow-50 text-yellow-700 text-sm font-bold px-3 py-1 rounded-full flex items-center border border-yellow-200">
              <svg class="w-4 h-4 mr-1 pb-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
              {{ number_format($fl['avg_rating'], 1) }}
            </div>
            <div class="flex justify-center mb-6 mt-4">
              <div class="w-28 h-28 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-4xl ring-4 ring-primary/20 group-hover:ring-primary/50 transition-all p-1">
                {{ substr($fl['nama_pengguna'], 0, 1) }}
              </div>
            </div>
            <div class="text-center flex-grow">
              <h3 class="text-xl font-bold text-dark mb-1">{{ $fl['nama_pengguna'] }}</h3>
              <p class="text-accent font-medium text-sm mb-4">{{ $fl['nama_kategori'] }}</p>
              <div class="flex items-center justify-center text-gray-500 text-sm mb-6 bg-gray-50 py-1.5 px-3 rounded-full w-max mx-auto">
                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                {{ $fl['alamat_lengkap'] ?: '-' }}
              </div>
            </div>
            <a href="{{ route('layanan.show', $fl['id_layanan'] ?? 1) }}" class="block text-center w-full bg-gray-50 border border-gray-200 text-dark group-hover:bg-dark group-hover:text-white group-hover:border-dark py-3 rounded-xl transition-all duration-300 font-semibold mt-auto">Lihat Profil</a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Why WorkLance -->
  <section id="why-worklance" class="py-24 bg-dark text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/20 rounded-full blur-[100px] -z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid lg:grid-cols-2 gap-16 items-center">
        <div>
          <h2 class="text-4xl font-bold mb-6">Kenapa Memilih <span class="text-accent">WorkLance?</span></h2>
          <p class="text-gray-300 text-lg mb-10 leading-relaxed">Kami bukan sekedar marketplace jasa. Kami percaya bahwa kualitas pekerjaan terbaik lahir dari orang-orang terbaik.</p>
          <div class="space-y-8">
            <div class="flex gap-4">
              <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0 text-primary"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg></div>
              <div><h4 class="text-xl font-bold mb-2">Fokus Tenaga Lokal</h4><p class="text-gray-400">Temukan profesional terbaik yang berada tak jauh darimu untuk kolaborasi langsung.</p></div>
            </div>
            <div class="flex gap-4">
              <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0 text-primary"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
              <div><h4 class="text-xl font-bold mb-2">Transparan & Terpercaya</h4><p class="text-gray-400">Review nyata dari pelanggan sebelumnya menjamin kualitas dan integritas.</p></div>
            </div>
            <div class="flex gap-4">
              <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0 text-primary"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
              <div><h4 class="text-xl font-bold mb-2">Mendukung Kerja Layak</h4><p class="text-gray-400">Berkontribusi pada SDGs 8 dengan memberdayakan komunitas pekerja independen lokal secara adil.</p></div>
            </div>
          </div>
        </div>
        <div class="relative">
          <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=800" alt="Tim bekerja" class="rounded-3xl shadow-2xl border-4 border-white/10">
          <div class="absolute -bottom-6 -right-6 bg-accent text-white p-6 rounded-2xl shadow-xl w-48 text-center animate-bounce duration-1000">
            <h3 class="text-4xl font-bold mb-1">10k+</h3>
            <p class="text-sm font-medium">Pengguna Bahagia</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-24 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-gradient-to-r from-primary to-blue-500 rounded-3xl p-10 md:p-16 text-center shadow-2xl relative overflow-hidden text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-accent/20 rounded-full blur-2xl translate-y-1/3 -translate-x-1/3"></div>
        <div class="relative z-10">
          <h2 class="text-4xl md:text-5xl font-bold mb-6">Punya keahlian yang bisa dijual?</h2>
          <p class="text-xl text-blue-50 mb-10 max-w-2xl mx-auto">Bergabung dengan ribuan freelancer sukses lainnya di sekitarmu. Mulai tawarkan jasamu tanpa biaya langganan bulanan.</p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('freelancer.mulai') }}" class="bg-accent hover:bg-orange-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">Mulai Jadi Freelancer</a>
            <a href="#" class="bg-white/20 hover:bg-white text-white hover:text-dark px-8 py-4 rounded-xl font-bold text-lg transition-all backdrop-blur-sm border border-white/30">Pelajari Lebih Lanjut</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

@endsection
