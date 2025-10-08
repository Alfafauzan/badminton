<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistory
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // HANYA tambahkan header jika pengguna sudah login (terautentikasi).
        // Untuk halaman publik, biarkan browser melakukan cache secara normal.
        if (Auth::check()) {
            return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        }

        // Jika pengguna adalah guest, kembalikan response apa adanya tanpa header no-cache.
        return $response;
    }
}