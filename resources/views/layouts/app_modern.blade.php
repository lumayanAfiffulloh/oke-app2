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
      <div class="container-fluid ">
        @if (session('status'))
          <div class="alert alert-info" role="alert">
            {{ session('status') }}
          </div>
        @endif
        @include('flash::message')
        @yield('content')
      </div>
    </div>
  </div>
  <script src={{asset("modern/src/assets/libs/jquery/dist/jquery.min.js")}}></script>
  <script src={{asset("modern/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js")}}></script>
  @stack('scripts')
  @stack('scripts2')
  <script src={{asset("modern/src/assets/js/sidebarmenu.js")}}></script>
  <script src={{asset("modern/src/assets/js/app.min.js")}}></script>
  <script src={{asset("modern/src/assets/libs/simplebar/dist/simplebar.js")}}></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- SELECT 2 --}}
  <link href={{ asset("select2/dist/css/select2.min.css") }} rel="stylesheet" />
  <script src={{ asset("select2/dist/js/select2.min.js") }}></script>

  <script>
    $(".placeholder-single").select2({
      placeholder: "-- Pilih Ketua Kelompok -- (Ketik untuk mencari pegawai!)",
      allowClear: true
    });
    $(".bentuk-jalur-select").select2({
      placeholder: "-- Pilih Bentuk Jalur --",
      allowClear: true
    });
    $(".placeholder-multiple").select2({
      placeholder: "-- Pilih Anggota Kelompok -- (Ketik untuk mencari pegawai!)"
    });
  </script>
</body>
</html>