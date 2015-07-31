<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;

/**
 * Weather Sys Class
 * 
 * @package WeatherForcast
 */
class WeatherSys extends Base 
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['sunrise', 'sunset'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [
        
            'country'   => null,   
            'sunrise'   => null,
            'sunset'    => null,  
        ]; 
    
}

