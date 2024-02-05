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

        // $this->app->bindIf(GeocodingServiceInterfaces::class, function($app){
        //     return new GeocodingService();

        // });
      
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
