<?php

namespace App\Libs\Weather;

use App\Contracts\Weather\ApiClient;


/**
 * The class send get request to access weather data from Open Weather Map API
 * 
 * @package WeatherForcast
 */
class OpenWeatherMapClient extends ApiRequest implements ApiClient
{
    
    /**
     * Client header attributes
     *
     * @var array
     */
    protected $defaultHeaderAttributes = [
        
        'Accept-Encoding'   => 'gzip',
        'Accept'            => 'application/json'        
    ];
    
    
    protected $shouldBeQueries = [
        
        'APPID'     => null,
        
        
    ];
    
    
    
    
}    


