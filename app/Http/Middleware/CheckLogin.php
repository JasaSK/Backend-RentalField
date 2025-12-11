<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // cek login
        $user = $request->user();

        if (!$user) {
            return redirect()->route('admin.page.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!in_array($user->role, $roles)) {
            return redirect()->route('admin.page.login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
