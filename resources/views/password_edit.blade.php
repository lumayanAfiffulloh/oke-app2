@extends('layouts.main_layout', ['title'=>'Ganti Password'])
@section('content')
<div class="card mb-3 bg-white">
  <div class="card-body p-0 ">
    <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
      <span>
        <a href="/profil" class="ti ti-arrow-left fw-bolder text-dark text-opacity-50 mx-2 link-custom"></a>
      </span>
      <a href="/profil" class="text-dark text-opacity-50 link-custom">Halaman Profil / </a>
      Edit Password
    </div>
    <div class="card-body py-3">
      <form method="POST" action="ganti_password" id="createFormID">
        @csrf
        <div class="mb-3 position-relative">
          <label for="password_sekarang" class="fw-semibold">Password Sekarang</label>
          <input type="password" class="form-control @error('password_sekarang') is-invalid @enderror"
            id="password_sekarang" name="password_sekarang">
          <span class="position-absolute end-0 top-50 me-3 text-dark text-opacity-25" id="togglePasswordSekarang"
            style="cursor: pointer;">
            <i class="ti ti-eye" id="toggleIconSekarang"></i>
          </span>
          @if ($errors->has('password_sekarang'))
          <span class="invalid-feedback d-block">
            <strong>{{ $errors->first('password_sekarang') }}</strong>
          </span>
          @endif
        </div>
        <div class="mb-3 position-relative">
          <label for="password_baru" class="fw-semibold">Password Baru</label>
          <input type="password" class="form-control @error('password_baru') is-invalid @enderror" id="password_baru"
            name="password_baru">
          <span class="position-absolute end-0 top-50 me-3 text-dark text-opacity-25" id="togglePasswordBaru"
            style="cursor: pointer;">
            <i class="ti ti-eye" id="toggleIconBaru"></i>
          </span>
          @if ($errors->has('password_baru'))
          <span class="invalid-feedback">
            <strong>{{ $errors->first('password_baru') }}</strong>
          </span>
          @endif
        </div>
        <div class="mb-3 position-relative">
          <label for="konfirmasi" class="fw-semibold">Konfirmasi Password Baru</label>
          <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror" id="konfirmasi"
            name="konfirmasi_password">
          <span class="position-absolute end-0 top-50 me-3 text-dark text-opacity-25" id="toggleKonfirmasi"
            style="cursor: pointer;">
            <i class="ti ti-eye" id="toggleIconKonfirmasi"></i>
          </span>
          @if ($errors->has('konfirmasi_password'))
          <span class="invalid-feedback">
            <strong>{{ $errors->first('konfirmasi_password') }}</strong>
          </span>
          @endif
        </div>
        <button type="submit" class="btn btn-primary" id="createAlert">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection

@push('password_visibility')
<script>
  function togglePasswordVisibility(toggleElement, passwordInputId, toggleIconId) {
    const passwordInput = document.getElementById(passwordInputId);
    const toggleIcon = document.getElementById(toggleIconId);

    toggleElement.addEventListener('mousedown', function() {
      passwordInput.type = 'text';
      toggleIcon.className = 'ti ti-eye-off';
    });

    toggleElement.addEventListener('mouseup', function() {
      passwordInput.type = 'password';
      toggleIcon.className = 'ti ti-eye';
    });

    toggleElement.addEventListener('mouseleave', function() {
      passwordInput.type = 'password';
      toggleIcon.className = 'ti ti-eye';
    });
  }

  togglePasswordVisibility(document.getElementById('togglePasswordSekarang'), 'password_sekarang', 'toggleIconSekarang');
  togglePasswordVisibility(document.getElementById('togglePasswordBaru'), 'password_baru', 'toggleIconBaru');
  togglePasswordVisibility(document.getElementById('toggleKonfirmasi'), 'konfirmasi', 'toggleIconKonfirmasi');
</script>
@endpush