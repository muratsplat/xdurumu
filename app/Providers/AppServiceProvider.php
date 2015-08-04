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
       $this->bindToForeCastResourceRepository();
       
       $this->bindToWeatherCurrentRepository();
        
       $this->registerWeatherForeCastServices();               
    }
    
    /**
     * To bind
     */
    private function bindToForeCastResourceRepository()
    {        
        $this->app->bind('App\Contracts\Weather\Repository\IForecastResourceRepository',
                'App\Repositories\Weather\ForecastResourceRepository');       
    }
    
    /**
     * To bind
     */
    private function bindToWeatherCurrentRepository()
    {        
        $this->app->bind(
                'App\Contracts\Weather\Repository\ICurrentRepository',
                'App\Repositories\Weather\CurrentRepository'
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
