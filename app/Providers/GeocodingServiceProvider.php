<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Location\GeocodingService;

use App\Services\Location\GeocodingServiceInterfaces;

class GeocodingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bindIf(GeocodingServiceInterfaces::class, function($app){
            return new GeocodingService();

        });    
    }
}