<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAdminLomba
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user login DAN rolenya adalah 'admin_lomba'
        if (Auth::check() && Auth::user()->role === 'admin_lomba') {
            return $next($request);
        }

        // [PERUBAHAN] Tampilkan halaman error 403 Forbidden.
        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
