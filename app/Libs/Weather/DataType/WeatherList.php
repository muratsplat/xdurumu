<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;


/**
 * Weather Hourly Data Class
 * 
 * @package WeatherForcast
 */
class WeatherList extends Base 
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
protected $required = ['weather_condition', 'weather_main','dt', 'source_updated_at'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [  
        
        'weather_condition'             => null,
        'weather_main'                  => null,   
        'weather_wind'                  => null,
        'weather_rain'                  => null,
        'weather_snow'                  => null,
        'weather_clouds'                => null,
        'source_updated_at'             => null,   
        'dt'                            => null,     
        ]; 
    
}

