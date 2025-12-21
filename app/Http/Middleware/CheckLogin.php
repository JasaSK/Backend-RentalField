<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Cek login
        if (!Auth::check()) {
            return redirect()
                ->route('admin.page.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        // dd($user);
        // 2. Cek role (jika role dikirim)
        if (!empty($roles) && !in_array($user->role, $roles)) {
            return redirect()
                ->route('admin.page.login')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
