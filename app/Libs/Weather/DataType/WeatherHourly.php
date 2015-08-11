<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;


/**
 * Weather Hourly Data Class
 * 
 * @package WeatherForcast
 */
class WeatherHourly extends Base 
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['city', 'weather_condition', 'weather_forecast_resource','weather_main' , 'dt'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [
        
        'city'                          => null,
        'weather_condition'             => null,
        'weather_forecast_resource'     => null,
        'weather_main'                  => null,   
        'weather_wind'                  => null,
        'weather_rain'                  => null,
        'weather_snow'                  => null,
        'weather_clouds'                => null,
//       'weather_sys'                   => null,
        'source_updated_at'             => null,   
        'dt'                            => null,
        ]; 
    
}

