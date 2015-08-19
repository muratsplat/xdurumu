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
                'App\Contracts\Weather\Repository\IForecastResource',
                'App\Repositories\Weather\ForecastResource');  
        
        $this->app->bind(
                'App\Contracts\Weather\Repository\IHourly',
                'App\Repositories\Weather\HourlyStat'
                );  
        
        $this->app->bind(
                'App\Contracts\Weather\Repository\ICurrent',
                'App\Repositories\Weather\Current'
                );     
        
        $this->app->bind(
                'App\Contracts\Repository\ICity',
                'App\Repositories\City'
                ); 
        
        $this->app->bind(
                'App\Contracts\Weather\Repository\IList', 
                'App\Repositories\Weather\ListRepo');
        
        $this->app->bind(
                'App\Contracts\Weather\Repository\Condition', 
                'App\Repositories\Weather\Condition');
        
        $this->app->bind(
                'App\Contracts\Weather\Repository\IDaily', 
                'App\Repositories\Weather\DailyStat');
                
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
