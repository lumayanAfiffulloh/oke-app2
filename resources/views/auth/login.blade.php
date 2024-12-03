@extends('auth.layout')
@section('title', 'Login | ' . config('app.name'))
<!-- Set page title -->

@section('content')
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
	data-sidebar-position="fixed" data-header-position="fixed">
	<div
		class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
		<div class="d-flex align-items-center justify-content-center w-100">
			<div class="row justify-content-center w-100">
				<div class="col-md-12 col-lg-6 col-xl-6 col-xxl-5">
					<div class="card mb-0">
						<div class="card-body">
							<div class="row logo-img text-end py-3">
								<div class="col-12 col-md-6 order-md-1 order-1 text-center text-md-end">
									<a href="/">
										<img src="{{ asset('img/dashboard.png') }}" width="180" alt="">
									</a>
								</div>
								<div class="col-12 col-md-6 order-md-2 order-2 text-center text-md-start my-auto">
									<p class="display-3 fw-bolder mb-0">Santi</p>
									<hr class="mt-0 mb-1 border-2 mx-auto mx-md-0" style="width: 60%; color: #3773e2">
									<p class="mb-0">Sistem Informasi Perencanaan</p>
									<p>Pengembangan Kompetensi</p>
								</div>
							</div>

							<form method="POST" action="{{ route('login') }}">
								@csrf
								<div class="row mb-3">
									<label for="login" class="col-md-4 col-form-label text-md-end">Masukkan Email/NIP/NPPU</label>
									<div class="col-md-6">
										<input id="login" class="form-control @error('login') is-invalid @enderror" name="login"
											value="{{ old('login') }}">
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
										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
											name="password">
										@if ($errors->has('password'))
										<span class="invalid-feedback">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
										@endif
									</div>
								</div>

								<div class="row mb-4">
									<div class="col-md-8 offset-md-4">
										<button type="submit" class="btn btn-primary">
											{{ __('Login') }}
										</button>

										@if (Route::has('password.request'))
										<a class="btn btn-link" href="{{ route('password.request') }}">
											Lupa Password Anda?
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
@endsection