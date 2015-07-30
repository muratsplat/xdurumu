<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;


/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
class City extends Base
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['id', 'name', 'country'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [
        
        'id'        => null, 
        'name'      => null, 
        'country'   => null, 
        'latitude'  => null, 
        'longitude' => null,
        ]; 
    
}

