<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
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
        Vite::prefetch(concurrency: 3);

        // DEBUG sementara: log semua query yg mengandung kata "phone"
        DB::listen(function ($query) {
            if (str_contains($query->sql, 'phone')) {
                Log::info('SQL_CONTAINS_PHONE', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                ]);
            }
        });
    }
}
