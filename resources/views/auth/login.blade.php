@extends('layouts.app_modern', ['title'=> 'Login'])

@section('content')
<div class="card bg-white" >
    <div class="card-header fs-5 fw-bolder" style="background-color: #ececec;">MASUK</div>
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="row mb-3">
                <label for="login" class="col-md-4 col-form-label text-md-end">Masukkan Email / NIK</label>

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
@endsection
