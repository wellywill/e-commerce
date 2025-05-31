<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        //
        Gate::define('access-admin-dashboard', function (User $user) {
            // Logika untuk menentukan apakah user adalah admin
            return $user->email === 'Gazali@gmail.com';
        });
        Gate::define('is-customer-ui', function (User $user) {
            return $user->email !== 'Gazali@gmail.com'; // Mengembalikan true jika BUKAN admin
        });
    }
}
