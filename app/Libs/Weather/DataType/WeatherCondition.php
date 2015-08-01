<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;

/**
 * Weather Condition 
 * 
 * @package WeatherForcast
 */
class WeatherCondition extends Base
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['open_weather_map_id', 'orgin_name', 'orgin_description'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [
        
            'open_weather_map_id'   => null,
            'name'                  => null,
            'description'           => null,
            'orgin_name'            => null,
            'orgin_description'     => null,  
            'icon'                  => null,
        ]; 
    
}

