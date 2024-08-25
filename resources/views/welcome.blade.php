@extends('layouts.app_modern', ['title' => 'Welcome'])
@section('content') 
<div class="card">
    <div class="card-body">
        <h1 class="h1">
            SELAMAT DATANG DI APLIKASI SINTA!
        </h1>
        <hr></hr>
        <div class="mt-3">
            <a href="/login" class="btn btn-primary me-1">Silahkan Login</a>
            <a href="/register" class="btn btn-warning">Silahkan Register</a>
        </div>
    </div>
</div>
@endsection