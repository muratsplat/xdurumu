<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;

/**
 * Weather Snow Class
 * 
 * @package WeatherForcast
 */
class WeatherSnow extends Base
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
                'snow'      => null,  
        ]; 
    
}

