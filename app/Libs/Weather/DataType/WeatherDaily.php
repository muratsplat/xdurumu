<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;


/**
 * Weather Daily Data Class
 * 
 * @package WeatherForcast
 */
class WeatherDaily extends Base 
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['city', 'weather_forecast_resource', 'list'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [
        
        'city'                          => null,      
        'weather_forecast_resource'     => null,
        'list'                          => null,
     
        ];   
        
        /**
         * To get all of list
         * 
         * @return \Illuminate\Support\Collection
         */
        public function getList() 
        {            
            return $this->attributes['list'];
        }
        
        /**
         * To get City
         * 
         * @return \App\Libs\Weather\DataType\City
         */
        public function getCity() 
        {            
            return $this->attributes['city'];
        }
        
        /**
         * To get City
         * 
         * @return \App\Libs\Weather\DataType\WeatherForecastResource
         */
        public function getWeatherForeCastResource() 
        {            
            return $this->attributes['weather_forecast_resource'];
        }    
}

