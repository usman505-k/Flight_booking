<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        // Prevent DB errors during build
        try {
            Schema::defaultStringLength(191);

            // Try connecting but don't crash if it fails
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            Log::warning("Database connection failed during build: " . $e->getMessage());
        }
    }
}
