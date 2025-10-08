<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleAccess
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Ambil semua nama role dari database
        $allRoles = Role::pluck('name')->toArray();

        // Cek apakah user memiliki salah satu role
        if ($user && $user->hasAnyRole($allRoles)) {
            return $next($request);
        }

        // Jika user tidak memiliki role yang valid, arahkan ke halaman home atau error
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
