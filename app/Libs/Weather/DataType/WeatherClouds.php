<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;

/**
 * Weather Clouds Class
 * 
 * @package WeatherForcast
 */
class WeatherClouds extends Base 
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['all'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [
        
          'all'       => null,
        ]; 
    
}

