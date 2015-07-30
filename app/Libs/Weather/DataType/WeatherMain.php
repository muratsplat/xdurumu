<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;


/**
 * WeatherMain Class
 * 
 * @package WeatherForcast
 */
class WeatherMain extends Base
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['temp', 'temp_min', 'temp_max'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [
        
            'temp'          => null,      
            'temp_min'      => null,
            'temp_max'      => null,
            'temp_eve'      => null,
            'temp_night'    => null,
            'temp_morn'     => null, 
            'pressure'      => null,
            'humidity'      => null,
            'sea_level'     => null,       
            'grnd_level'    => null,
            'temp_kf'       => null,  
        ]; 
    
}

