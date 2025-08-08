<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function redirectTo()
    {
        $user = auth()->user();

        if ($user->role === 'pustakawan') {
            return '/admin/books';
        }

        if ($user->role === 'admin') {
            return '/admin/dashboard';
        }

        return '/buku'; // untuk peminjam
    }

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
        //
    }
}
