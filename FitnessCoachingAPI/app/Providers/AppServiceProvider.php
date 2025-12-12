<?php

namespace App\Providers;

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
        // Disable SSL verification globally for all SSL/TLS connections
        // This is required for Gmail SMTP on Windows
        stream_context_set_default([
            'ssl' => [
                'allow_self_signed' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
                'verify_depth' => 0,
                'cafile' => null,
                'capath' => null,
            ],
        ]);
    }
}
