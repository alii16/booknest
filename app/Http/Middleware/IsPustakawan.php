<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPustakawan
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user adalah pustakawan, lanjut ke request
        if (auth()->check() && auth()->user()->role === 'pustakawan') {
            return $next($request);
        }

        // Jika user adalah admin, redirect ke halaman admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        // Jika bukan pustakawan maupun admin, tolak akses
        abort(403, 'Akses hanya untuk pustakawan atau admin.');
    }
}
