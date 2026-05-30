<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PesertaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('peserta_id')) {
            return redirect()->route('peserta.login')->withErrors(['error' => 'Silakan masuk terlebih dahulu menggunakan nomor NISN & tanggal lahir Anda.']);
        }

        return $next($request);
    }
}
