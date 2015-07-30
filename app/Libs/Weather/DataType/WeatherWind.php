<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;

/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
class WeatherWind extends Base
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['speed'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [
        
            'speed'     => null,
            'deg'       => null,        
        ]; 
    
}

