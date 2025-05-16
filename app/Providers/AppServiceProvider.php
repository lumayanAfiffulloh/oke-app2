<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\TenggatRencana;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Observers\TenggatRencanaObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Gate::define('admin', function(User $user) {
            // Mengecek apakah user memiliki role 'admin' dalam relasi roles
            return $user->roles->contains('role', 'admin');
        });

        Gate::define('pegawai', function(User $user) {
            // Mengecek apakah user memiliki role 'pegawai' dalam relasi roles
            return $user->roles->contains('role', 'pegawai');
        });

        Gate::define('ketua_kelompok', function(User $user) {
            // Mengecek apakah user memiliki role 'ketua_kelompok' dalam relasi roles
            return $user->roles->contains('role', 'ketua_kelompok');
        });

        Gate::define('verifikator', function(User $user) {
            // Mengecek apakah user memiliki role 'verifikator' dalam relasi roles
            return $user->roles->contains('role', 'verifikator');
        });
        
        Gate::define('approver', function(User $user) {
            // Mengecek apakah user memiliki role 'approver' dalam relasi roles
            return $user->roles->contains('role', 'approver');
        });
    }
}
