@extends('auth.layout')
@section('title', 'Login | ' . config('app.name'))

@section('content')
<!-- Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
	data-sidebar-position="fixed" data-header-position="fixed">
	<div
		class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
		<div class="d-flex align-items-center justify-content-center w-100">
			<div class="row justify-content-center w-100">
				<div class="col-md-10 col-lg-8 col-xl-6 col-xxl-5">
					<div class="card mb-0">
						<div class="card-body px-5 py-4">
							<div class="row logo-img align-items-center py-3 pt-0">
								<div class="col-md-6 text-center text-md-end">
									<a href="/">
										<img src="{{ asset('img/dashboard1.png') }}" width="180" alt="">
									</a>
								</div>
								<div class="col-md-6 text-center text-md-start my-auto">
									<p class="display-4 fw-bolder mb-0">Santi</p>
									<hr class="mt-0 mb-1 border-2 mx-auto mx-md-0" style="width: 60%; color: #3773e2">
									<p class="mb-0">Sistem Informasi Perencanaan</p>
									<p>Pengembangan Kompetensi</p>
								</div>
							</div>

							<form method="POST" action="{{ route('login') }}">
								@csrf
								<div class="mb-4">
									<label for="login" class="form-label">Masukkan Email/NIP/NPPU</label>
									<input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login"
										value="{{ old('login') }}" autocomplete="username">
									@error('login')
									<div class="invalid-feedback">
										<strong>{{ $message }}</strong>
									</div>
									@enderror
								</div>

								<div class="mb-4">
									<label for="password" class="form-label">{{ __('Password') }}</label>
									<div class="position-relative">
										<input type="password" class="form-control @error('password') is-invalid @enderror"
											id="password_login" name="password" autocomplete="current-password">
										<span class="position-absolute end-0 top-50 translate-middle-y me-3 text-dark text-opacity-25"
											id="togglePasswordLogin" style="cursor: pointer;">
											<i class="ti ti-eye" id="toggleIconLogin"></i>
										</span>
										@error('password')
										<div class="invalid-feedback">
											<strong>{{ $message }}</strong>
										</div>
										@enderror
									</div>
								</div>

								<div class="d-flex justify-content-between align-items-center mb-4">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember')
											? 'checked' : '' }}>
										<label class="form-check-label" for="remember">
											{{ __('Remember Me') }}
										</label>
									</div>
									@if (Route::has('password.request'))
									<a class="text-primary" href="{{ route('password.request') }}">
										Lupa Password Anda?
									</a>
									@endif
								</div>

								<div class="d-grid mb-2">
									<button type="submit" class="btn btn-primary btn-lg">
										{{ __('Login') }}
									</button>
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

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const togglePassword = document.getElementById('togglePasswordLogin');
		const passwordInput = document.getElementById('password_login');
		const toggleIcon = document.getElementById('toggleIconLogin');

		togglePassword.addEventListener('mousedown', function() {
			passwordInput.type = 'text';
			toggleIcon.classList.remove('ti-eye');
			toggleIcon.classList.add('ti-eye-off');
		});

		togglePassword.addEventListener('mouseup', function() {
			passwordInput.type = 'password';
			toggleIcon.classList.remove('ti-eye-off');
			toggleIcon.classList.add('ti-eye');
		});

		togglePassword.addEventListener('mouseleave', function() {
			passwordInput.type = 'password';
			toggleIcon.classList.remove('ti-eye-off');
			toggleIcon.classList.add('ti-eye');
		});
	});
</script>