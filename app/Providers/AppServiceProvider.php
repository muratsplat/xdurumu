<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libs\Weather\ApiServiceFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
     
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Weather Forecast Resource Repository
        $this->app->bind(
                'App\Contracts\Weather\IForecastResourceRepository', 
                'App\Repositories\Weather\ForecastResourceRepository'
                );
        
        $this->registerWeatherForeCastServices();               
    }
    
    /**
     * Register Weather ForeCast Resource Servise
     * 
     * 
     * @return void
     */
    protected function registerWeatherForeCastServices()
    {
        $this->app->singleton('app.weather.factory', function($app) {            
            
            return new ApiServiceFactory($app);    
        });
    }
}
