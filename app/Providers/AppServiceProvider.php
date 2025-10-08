<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom Blade directive: @rolecan
        Blade::if('rolecan', function ($permission) {
            $user = Auth::user();

            if (!$user) {
                return false;
            }

            // Gunakan session 'selected_role' untuk menentukan role aktif
            if (session()->has('selected_role')) {
                $activeRoleName = session('selected_role');
                return $user->hasRole($activeRoleName) &&
                       Role::findByName($activeRoleName)->hasPermissionTo($permission);
            }

            // Fallback jika tidak ada peran yang dipilih
            return $user->can($permission);
        });

        // Global gate override untuk superadmin
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
    }
}
