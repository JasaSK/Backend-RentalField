<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        // cek login
        if (!session()->has('user_id')) {
            return redirect()->route('admin.page.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // cek role admin
        if (session('role') !== 'admin') {
            return back()->with('error', 'Akses ditolak. Anda bukan admin.');
        }

        return $next($request);
    }
}
