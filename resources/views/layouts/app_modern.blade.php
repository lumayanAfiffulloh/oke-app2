<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? '' }} | {{ config('app.name', 'Laravel') }}</title>
  <link rel="shortcut icon" href="{{ asset('img/undip.png') }}">
  <link rel="stylesheet" href={{ asset("modern/src/assets/css/styles.min.css") }}>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
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

  {{-- DATA TABLES --}}
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

  <script>
    $(document).ready(function(){
      $('#myTable').DataTable({
        "language":{
          "url":"{{asset('modern/src/assets/js/datatables_custom.json') }}",
          "sEmptyTable":"Data Tidak Tersedia"
        }
      });
    });
  </script>

  {{-- SWEET ALERT --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- SELECT 2 --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
  @stack('bentuk_jalur')

  <script>
    $(".placeholder-single").select2({
      theme: 'bootstrap4',
      placeholder: "-- Pilih Ketua Kelompok -- (Ketik untuk mencari pegawai!)",
      allowClear: true
    });
    $(".placeholder-multiple").select2({
      theme: 'bootstrap4',
      placeholder: "-- Pilih Anggota Kelompok -- (Ketik untuk mencari pegawai!)"
    });
    $(".bentukjalur-placeholder-single").select2({
      theme: 'bootstrap4',
    placeholder: "-- Pilih Bentuk Jalur --",
    allowClear: true,
    dropdownParent:'#createPelatihanModal'
    });
  </script>

  {{-- SWEET ALERT UNTUK CREATE --}}
  <script>
    document.getElementById('createAlert').onclick = function(event){
      event.preventDefault();
      Swal.fire({
        title: "Konfirmasi Data",
        text: "Pastikan Data yang Anda Isikan Sudah Benar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Simpan",
        cancelButtonText: "Batal"
      }).then((result) => {
        if (result.isConfirmed){
          // Submit form atau aksi lain setelah konfirmasi
          document.getElementById('createFormID').submit(); // Sesuaikan ID form
        }
      });
    }
  </script>

  {{-- SWEET ALERT UNTUK DELETE --}}
  <script>
    document.querySelectorAll('.deleteAlert').forEach(function(button, index) {
          button.addEventListener('click', function(event) {
              event.preventDefault(); // Mencegah submit langsung
              Swal.fire({
                  title: "Apakah Anda Yakin?",
                  text: "Data Akan Dihapus Permanen dari Basis Data!",
                  icon: "warning",
                  showCancelButton: true,
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Ya, Hapus!",
                  cancelButtonText: "Batal"
              }).then((result) => {
                  if (result.isConfirmed) {
                      Swal.fire({
                          title: "Berhasil!",
                          text: "Data Berhasil Dihapus",
                          icon: "error"
                      }).then(() => {
                          // Submit form yang terkait dengan tombol ini
                          button.closest('form').submit(); // Submit form terkait
                      });
                  }
              });
          });
      });
  </script>


</body>

</html>