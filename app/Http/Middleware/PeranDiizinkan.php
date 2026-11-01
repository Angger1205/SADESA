<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeranDiizinkan
{
    /**
     * Izinkan request hanya jika peran pengguna ada dalam daftar $peran.
     * Contoh pemakaian di route: PeranDiizinkan::class.':admin,staf'
     */
    public function handle(Request $request, Closure $next, string ...$peran): Response
    {
        $pengguna = $request->user();

        if (! $pengguna || ! in_array($pengguna->role, $peran, true)) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}