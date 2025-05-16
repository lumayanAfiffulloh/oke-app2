<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? '' }} | {{ config('app.name', 'Laravel') }}</title>
  <link rel="shortcut icon" href="{{ asset('img/undip.png') }}">
  <link rel="stylesheet" href={{ asset("modern/src/assets/css/styles.min.css") }}>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
</head>

<style>
  /* Override hover dengan selector yang lebih spesifik */
  .card-header a.link-custom:hover {
    color: #5D87FF !important;
    /* Warna saat hover (hitam solid) */
    opacity: 1 !important;
    /* Hilangkan opacity saat hover */
  }
</style>

<body>
  <!--  BODY WRAPPER -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- SIDEBAR -->
    <x-sidebar></x-sidebar>
    {{-- SIDEBAR END --}}

    <!--  MAIN WRAPPER -->
    <div class="body-wrapper">
      <!--  HEADER  -->
      @auth
      <x-header></x-header>
      @endauth
      {{-- HEADER END --}}
      {{-- KONTEN --}}
      <div class="container-fluid ">
        @if (session('status'))
        <div class="alert alert-info" role="alert">
          {{ session('status') }}
        </div>
        @endif

        {{-- MODAL PERINGATAN GANTI PASSWORD --}}
        @if(session('default_password'))
        {{-- MODAL NOTIFIKASI GANTI PASSWORD --}}
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true"
          id="notifPasswordModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body border border-2 mx-3 rounded-2" style="margin-top: 24px">
                <div class="d-flex">
                  <div class="icon me-3">
                    <i class="ti ti-alert-triangle text-warning display-6"></i>
                  </div>
                  <div>
                    <p class="fs-5 fw-semibold text-dark mb-1">
                      Perhatian: Password Anda masih menggunakan password default!
                    </p>
                    <p class="text-muted mb-3">
                      Untuk mengakses halaman ini, harap segera mengganti password Anda dengan yang lebih aman.
                    </p>
                    <a href="ganti_password" class="btn btn-warning btn-sm text-white px-4">
                      <i class="ti ti-key me-2"></i> Ganti Password
                    </a>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                {{-- Tidak perlu tombol close --}}
              </div>
            </div>
          </div>
        </div>
        @endif

        @include('flash::message')
        @yield('content')
      </div>
    </div>
  </div>

  {{-- SCRIPT TEMPLATE --}}
  <script src={{asset("modern/src/assets/libs/jquery/dist/jquery.min.js")}}></script>
  <script src={{asset("modern/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js")}}></script>
  @stack('scripts')
  @stack('scripts2')
  <script src={{asset("modern/src/assets/js/sidebarmenu.js")}}></script>
  <script src={{asset("modern/src/assets/js/app.min.js")}}></script>
  <script src={{asset("modern/src/assets/libs/simplebar/dist/simplebar.js")}}></script>

  {{-- password visibility togle --}}
  @stack('password_visibility')
  @stack('password_login')

  {{-- SCRIPT MODAL PERINGATAN GANTI PASSWORD --}}
  <script>
    document.addEventListener("DOMContentLoaded", function () {
    const modalElement = document.getElementById('notifPasswordModal');
    if (modalElement && modalElement.dataset.show === undefined) {
      const modal = new bootstrap.Modal(modalElement);
      modal.show();
    }
  });
  </script>

  {{-- DATA TABLES --}}
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

  {{-- UMUM --}}
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

  <script>
    $(document).ready(function() {
    $('.datatables').DataTable({
      "language":{
        "url":"{{asset('modern/src/assets/js/datatables_custom.json') }}",
        "sEmptyTable":"Data Tidak Tersedia"
      }
    });
  });
  </script>

  {{-- SELECT 2 --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
  @stack('bentuk_jalur')

  <script>
    $(".placeholder-single").select2({
    dropdownParent: $('#createKelompokModal'),
    theme: 'bootstrap4',
    placeholder: "-- Pilih Ketua Kelompok -- (Ketik untuk mencari pegawai!)",
    allowClear: true
  });
  $(".placeholder-single-edit").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Ketua Kelompok -- (Ketik untuk mencari pegawai!)",
    allowClear: true
  });
  $(".placeholder-multiple").select2({
    dropdownParent: $('#createKelompokModal'),
    theme: 'bootstrap4',
    placeholder: "-- Pilih Anggota Kelompok -- (Ketik untuk mencari pegawai!)"
  });
  $(".placeholder-multiple-edit").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Anggota Kelompok -- (Ketik untuk mencari pegawai!)"
  });
  
  $(".bentukjalur-placeholder-single").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Bentuk Jalur --",
    allowClear: true,
    dropdownParent:'#createPelatihanModal'
  });

  $(".bentuk-jalur-single").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Bentuk Jalur --",
    allowClear: true,
  });
  
  $(".kategori-single").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Kategori --",
    allowClear: true
  });

  $(".kategori-edit-single").select2({
    theme: 'bootstrap4',
  });

  $(".bentuk-jalur-single-edit").select2({
    theme: 'bootstrap4',
  });
  
  $(".jenjang-single").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Jenjang --",
    allowClear: true
  });

  $(".rumpun-single").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Rumpun --",
    allowClear: true
  });

  $(".jurusan-single").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Jurusan --",
    allowClear: true
  });
  
  $(".nama-pelatihan-single").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Nama Pelatihan --",
    allowClear: true
  });

  $(".jenis-pendidikan-single").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Jenis Pendidikan --",
    allowClear: true
  });

  $(".rumpun-single-pelatihan").select2({
    theme: 'bootstrap4',
    placeholder: "-- Pilih Rumpun --",
    allowClear: true
  });
  </script>

  {{-- SWEET ALERT --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- SWEET ALERT HALAMAN RENCANA PEMBELAJARAN / CREATE --}}
  @stack('alert-rencana')

  {{-- ALERT UNTUK validasi KELOMPOK --}}
  @stack('alert-validasi-kelompok')
  @stack('alert-setujui-tolak')

  {{-- ALERT UNTUK AJUKAN validasi --}}
  @stack('alert-ajukan-validasi')

  {{-- SWEET ALERT UNTUK CREATE --}}
  <script>
    document.getElementById('createAlert').onclick = function(event){
      event.preventDefault();
      Swal.fire({
        title: "Konfirmasi Data!",
        text: "Pastikan data yang anda isikan sudah benar!",
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
          confirmButtonColor: "#f9886b",
          cancelButtonColor: "#6E7881",
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

  {{-- UNTUK EDIT --}}
  <script>
    document.getElementById('editAlert').onclick = function(event){
      event.preventDefault();
      Swal.fire({
        title: "Konfirmasi Data!",
        text: "Pastikan Data yang Anda Edit Sudah Benar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#FFAE1F",
        cancelButtonColor: "#6E7881",
        confirmButtonText: "Simpan",
        cancelButtonText: "Batal"
      }).then((result) => {
        if (result.isConfirmed) {
          // Submit form atau aksi lain setelah konfirmasi
          document.getElementById('editFormID').submit(); // Sesuaikan ID form
        }
      });
    }
  </script>

  {{-- UNTUK TENGGAT RENCANA --}}
  <script>
    document.querySelectorAll('.createJadwalAlert').forEach(function(button, index) {
      button.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah submit langsung
        Swal.fire({
          title: "Konfirmasi Data!",
          text: "Pastikan data yang anda isikan sudah benar!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Simpan",
          cancelButtonText: "Batal"
        }).then(() => {
          // Submit form yang terkait dengan tombol ini
          button.closest('form').submit(); // Submit form terkait
        });
      });
    });
  </script>
</body>

</html>