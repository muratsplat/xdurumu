<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    }
}
