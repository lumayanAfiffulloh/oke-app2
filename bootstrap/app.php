<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'pegawai-access' => \App\Http\Middleware\Pegawai::class,
            'admin-ketua_kelompok' => \App\Http\Middleware\KetuaKelompok::class,
            'verifikator-access' => \App\Http\Middleware\Verifikator::class,
            'approval-access' => \App\Http\Middleware\Approval::class,
            'admin-access' => \App\Http\Middleware\Admin::class,
            'checkrole' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
