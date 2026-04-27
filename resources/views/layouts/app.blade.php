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

</body>
</html>
