<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Middleware\CheckDefaultPassword;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Tambahkan ini:
        $middleware->web(append: [
            //
        ]);
        
        // Middleware existing Anda:
        $middleware->alias([
            'checkrole' => CheckRole::class,
            'check.default.password' => CheckDefaultPassword::class,
        ]);
    })
    ->withProviders([
        App\Providers\ViewComposerServiceProvider::class, 
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();