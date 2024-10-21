<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LimitLoginAttempts
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Inisialisasi jumlah percobaan login
        $maxAttempts = 3;
        $attempts = Session::get('login_attempts', 0);

        // Cek jika sudah melebihi batas
        if ($attempts >= $maxAttempts) {
            return response()->json(['error' => 'Terlalu banyak percobaan login. Silakan coba lagi nanti.'], 429);
        }

        return $next($request);
    }
}
