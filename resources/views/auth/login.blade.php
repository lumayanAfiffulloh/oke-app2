<head>
	<link rel="icon" href="{{ asset('img/undip.png') }}">
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? '' }} | {{ config('app.name', 'Laravel') }}</title>
  <link rel="shortcut icon" type="image/png" href={{ asset("modern/src/assets/images/logos/favicon.png") }}/>
  <link rel="stylesheet" href= {{ asset("modern/src/assets/css/styles.min.css") }} />
  <link rel="icon" href="{{ asset('img/undip.png') }}">
</head>
<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <div class="row logo-img text-end py-3">
									<div class="col-6 justify-content-end">
										<img src="{{ asset('img/dashboard.png') }}" width="180" alt="">
									</div>
									<div class="col-6 text-start my-auto">
										<p class="display-3 fw-bolder mb-0">Santi</p>
										<hr class="mt-0 mb-1 border-2" style="width: 60%; color: #3773e2">
										<p>Sistem Informasi Perencanaan Pengembangan Kompetensi</p>
									</div>
                </div>
                <form method="POST" action="{{ route('login') }}">
									@csrf
									<div class="row mb-3">
										<label for="login" class="col-md-4 col-form-label text-md-end">Masukkan Email / NIP</label>
										<div class="col-md-6">
											<input id="login" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}">
											@if ($errors->has('login'))
												<span class="invalid-feedback">
													<strong>{{ $errors->first('login') }}</strong>
												</span>
											@endif
										</div>
									</div>
			
									<div class="row mb-3">
										<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
										<div class="col-md-6">
											<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
											@if ($errors->has('password'))
												<span class="invalid-feedback">
														<strong>{{ $errors->first('password') }}</strong>
												</span>
											@endif
										</div>
									</div>
			
									<div class="row mb-3">
										<div class="col-md-6 offset-md-4">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
												<label class="form-check-label" for="remember">
														{{ __('Remember Me') }}
												</label>
											</div>
										</div>
									</div>
			
									<div class="row mb-0">
										<div class="col-md-8 offset-md-4">
											<button type="submit" class="btn btn-primary">
												{{ __('Login') }}
											</button>
	
											@if (Route::has('password.request'))
												<a class="btn btn-link" href="{{ route('password.request') }}">
													{{ __('Forgot Your Password?') }}
												</a>
											@endif
										</div>
									</div>
							</form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>