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
    protected $required = ['city', 'weather_forecast_resource', 'list'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [
        
        'city'                          => null,      
        'weather_forecast_resource'     => null,
        'list'                          => null,
     
        ]; 
    
}

