<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SANTI | {{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" type="image/png" href={{ asset("modern/src/assets/images/logos/favicon.png") }}/>
    <link rel="stylesheet" href= {{ asset("modern/src/assets/css/styles.min.css") }} />
    <link rel="icon" href="{{ asset('img/undip.png') }}">
</head>

<body>
    {{-- BODY --}}
    <div class="container-fluid">
        <div class="row min-vh-100 align-items-center">
            <div class="col-lg-5">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('img/dashboard.png') }}" style="width: 70%"></img>
                </div>
            </div>
            <div class="col-lg-7" style="padding-right: 10%"> 
                <div>
                    <h2 class="display-5 fw-bold">Selamat Datang di Aplikasi</h2>
                    <span class="display-5 text-primary fw-bolder">SANTI</span><hr class="border-primary" style="border-width : 2px">
                    <p class="fs-4 mt-1">SANTI, atau Sistem Informasi Perencanaan Pengembangan Kompetensi, dikembangkan oleh BPSDM Undip untuk memfasilitasi perencanaan, pemantauan, dan evaluasi pengembangan kompetensi pegawai di Universitas Diponegoro.</p>
                    <div class="mt-2">
                        <a href="/login" class="btn btn-primary fs-4 me-1 tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-110 hover:tw-bg-blue-600 tw-duration-200">Login</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    {{-- BODY END --}}
    





</body>

<script src={{asset("modern/src/assets/libs/jquery/dist/jquery.min.js")}}></script>
<script src={{asset("modern/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js")}}></script>
<script src={{asset("modern/src/assets/js/sidebarmenu.js")}}></script>
<script src={{asset("modern/src/assets/js/app.min.js")}}></script>
<script src={{asset("modern/src/assets/libs/simplebar/dist/simplebar.js")}}></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>