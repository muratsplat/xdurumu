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
       $this->registerWeatherForeCastServices();               
       
       $this->bindings();
    }    

    
    /**
     * Bindings
     * 
     * @return void
     */
    protected function bindings()
    {
        $this->app->bind(
                'App\Contracts\Weather\Repository\IForecastResourceRepository',
                'App\Repositories\Weather\ForecastResourceRepository');  
        
        $this->app->bind(
                'App\Contracts\Weather\Repository\IHourlyRepository',
                'App\Repositories\Weather\HourlyStatRepository'
                );  
        
        $this->app->bind(
                'App\Contracts\Weather\Repository\ICurrentRepository',
                'App\Repositories\Weather\CurrentRepository'
                );     
        
        $this->app->bind(
                'App\Contracts\Repository\ICityRepository',
                'App\Repositories\CityRepository'
                ); 
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
