<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;


/**
 * WeatherForecastResource
 * 
 * @package WeatherForcast
 */
class WeatherForecastResource extends Base
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['id', 'name', 'url', 'apiable'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [        
        'name'                  => null,
        'description'           => null,
        'url'                   => null,
        'api_url'               => null,           
        'enable'                => null,
        'paid'                  => null,
        'apiable'               => null,
        
        ]; 
    
}

