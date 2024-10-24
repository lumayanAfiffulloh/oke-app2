@extends('layouts.app_modern', ['title'=>'Ganti Password'])
@section('content')
  <div class="card mb-3 bg-white">
    <div class="card-body p-0 ">
      <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">
        <span class="me-2">
          <a href="/profil" class="ti ti-arrow-left fw-bolder ms-2"></a>
        </span>
        Edit Password</div>
      <div class="card-body py-3">
      <form method="POST" action="ganti_password" id="editFormID">
        @csrf
        <div class="mb-3">
          <label for="password_sekarang" class="form-label">Password Sekarang</label>
          <input type="password" class="form-control @error('password_sekarang') is-invalid @enderror" id="password_sekarang" name="password_sekarang">
          @if ($errors->has('password_sekarang'))
            <span class="invalid-feedback">
              <strong>{{ $errors->first('password_sekarang') }}</strong>
            </span>
          @endif
        </div>
        <div class="mb-3">
          <label for="password_baru" class="form-label">Password Baru</label>
          <input type="password" class="form-control @error('password_baru') is-invalid @enderror" id="password_baru" name="password_baru">
          @if ($errors->has('password_baru'))
            <span class="invalid-feedback">
              <strong>{{ $errors->first('password_baru') }}</strong>
            </span>
          @endif
        </div>
        <div class="mb-3">
          <label for="konfirmasi" class="form-label">Konfirmasi Password Baru</label>
          <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror" id="konfirmasi" name="konfirmasi_password">
          @if ($errors->has('konfirmasi_password'))
            <span class="invalid-feedback">
              <strong>{{ $errors->first('konfirmasi_password') }}</strong>
            </span>
          @endif
        </div>
        <button type="submit" class="btn btn-primary" id="editAlert">Submit</button>
      </form>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('editAlert').onclick = function(event){
    event.preventDefault();
    Swal.fire({
        title: "Konfirmasi Data",
        text: "Pastikan Data yang Anda Edit Sudah Benar",
        icon: "warning",
        showCancelButton: true,
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
@endsection