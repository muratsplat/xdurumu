<?php

namespace App\Libs\Weather\DataType;

use App\Libs\Weather\DataType\Base;


/**
 * Weather Hourly Data Class
 * 
 * @package WeatherForcast
 */
class WeatherList extends Base 
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required = ['weather_conditions', 'weather_main','dt', 'source_updated_at'];
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes = [  
        
        'weather_conditions'            => null,
        'weather_main'                  => null,   
        'weather_wind'                  => null,
        'weather_rain'                  => null,
        'weather_snow'                  => null,
        'weather_clouds'                => null,
        'source_updated_at'             => null,   
        'dt'                            => null,     
        ]; 
    
    
        /**
         * To get WeatherMain Data Object
         * 
         * @return \App\Libs\Weather\DataType\WeatherMain
         */
        public function getMain()
        {
            return $this->attributes['weather_main'];            
        }       
    
        /**
         * To get WeatherRain Data Object
         * 
         * @return \App\Libs\Weather\DataType\WeatherRain
         */
        public function getRain()
        {
            return $this->attributes['weather_rain'];            
        }  
        
        /**
         * To get WeatherCondition Data Object
         * 
         * @return \Illuminate\Support\Collection
         */
        public function getConditions()
        {
            return $this->attributes['weather_conditions'];            
        }
        
        /**
         * To get WeatherClouds Data Object
         * 
         * @return \App\Libs\Weather\DataType\WeatherClouds
         */
        public function getClouds()
        {
            return $this->attributes['weather_clouds'];            
        }  
        
        /**
         * To get WeatherSnow Data Object
         * 
         * @return \App\Libs\Weather\DataType\WeatherSnow
         */
        public function getSnow()
        {
            return $this->attributes['weather_snow'];            
        }
        
        /**
         * To get WeatherWind Data Object
         * 
         * @return \App\Libs\Weather\DataType\WeatherWind
         */
        public function getWind()
        {
            return $this->attributes['weather_wind'];            
        } 
        
        /**
         * To get Source Update At
         * 
         * @return string
         */
        public function getSourceUpdatedAt()
        {
            return $this->attributes['source_updated_at'];            
        }           
        
        /**
         * To get Data Time
         * 
         * @return string
         */
        public function getDt()
        {
            return $this->attributes['dt'];            
        }  
}