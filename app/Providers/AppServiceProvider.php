<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        // existing line (keep it)
        Schema::defaultStringLength(191);

        // ✅ Auto create admin if not exists
        if (!User::where('email', 'usman@project.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'usman@project.com',
                'password' => Hash::make('admin123'),
                'is_admin' => 1
            ]);
        }
    }
}
