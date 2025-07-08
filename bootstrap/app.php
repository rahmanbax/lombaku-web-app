<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// use-statement ini tidak diperlukan jika Anda tidak menggunakannya di tempat lain
// use App\Http\Middleware\Authenticate; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // <<< PERUBAHAN UTAMA DI SINI >>>
        // Gunakan 'prepend' untuk MENAMBAHKAN middleware ke awal grup 'api',
        // bukan menggantinya secara keseluruhan.
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        // Kode alias Anda tetap dipertahankan, ini sudah benar.
        // Laravel 11+ sudah otomatis melakukan ini, tapi tidak masalah jika ada di sini.
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'role.kemahasiswaan' => \App\Http\Middleware\CheckRoleKemahasiswaan::class,
            'role.adminlomba'    => \App\Http\Middleware\CheckRoleAdminLomba::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
