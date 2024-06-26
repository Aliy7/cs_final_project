<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Location\GeocodingService;
use App\Services\Location\GeocodingServiceInterfaces;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
