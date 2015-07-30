<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;

/**
 * Weather Rain Class
 * 
 * @package WeatherForcast
 */
class WeatherRain extends Base 
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['3h'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [
        
                '3h'        => null,
                'rain'      => null,  
        ]; 
    
}

