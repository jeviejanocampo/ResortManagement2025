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
     * Uncomment the boot method if you want to use ngrok
     */
    // public function boot()
    // {
    //     if (app()->environment('local')) {
    //         URL::forceScheme('https');
    //     }
    // }
    
}
