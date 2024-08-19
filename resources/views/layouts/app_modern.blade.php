<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? '' }} | {{ config('app.name', 'Laravel') }}</title>
  <link rel="shortcut icon" type="image/png" href={{ asset("modern/src/assets/images/logos/favicon.png") }}/>
  <link rel="stylesheet" href= {{ asset("modern/src/assets/css/styles.min.css") }} />
  <link rel="icon" href="{{ asset('img/undip.png') }}">
  @vite('resources/css/app.css')
</head>

<body>
  <!--  BODY WRAPPER -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- SIDEBAR -->
    <x-sidebar></x-sidebar>

    <!--  MAIN WRAPPER -->
    <div class="body-wrapper">
      <!--  HEADER  -->
      @auth
      <x-header></x-header>
      @endauth

      {{-- KONTEN --}}
      <div class="container-fluid">
        @if (session()->has('pesan'))
          <div class="alert alert-info" role="alert">
            {{ session('pesan') }}
          </div>
        @endif
        @include('flash::message')
        @yield('content')
      </div>
    </div>
  </div>
  <script src={{asset("modern/src/assets/libs/jquery/dist/jquery.min.js")}}></script>
  <script src={{asset("modern/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js")}}></script>
  <script src={{asset("modern/src/assets/js/sidebarmenu.js")}}></script>
  <script src={{asset("modern/src/assets/js/app.min.js")}}></script>
  <script src={{asset("modern/src/assets/libs/simplebar/dist/simplebar.js")}}></script>
</body>

</html>