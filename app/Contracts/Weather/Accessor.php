<?php

namespace App\Contracts\Weather;

/**
 * Weather Accesstor Interfece to acces all weather forcast apies
 * 
 */
interface Accessor
{        
        /**
         * Create a new Instance
         * 
         * @param string $json JSON Object
         * @return \static
         */
        public function createNewInstance($json);      
        
        /**
         * To select what data is current
         * 
         * @return \App\Contracts\Weather\Accessor
         */
        public function current();     
        
        /**
         * To select what data is hourly
         * 
         * @return \App\Contracts\Weather\Accessor
         */
        public function hourly();
    
        /**
         * To select what data is daily
         * 
         * @return \App\Contracts\Weather\Accessor
         */
        public function daily();
        
        /**
         * To export Weather Data Object
         * 
         * @return array
         * @throws LogicException
         */
        public function export();
  
        
        /**
         * To check data is current
         * 
         * @return bool
         */
        public function isCurrent();
    
        
        /**
         * To check data is hourly
         * 
         * @return bool
         */
        public function isHourly();
        
        /**
         * To check data is hourly
         * 
         * @return bool
         */
        public function isDaily();
        
       /**
         * To check data is unknown
         * 
         * @return bool
         */
        public function isUnknown();   
    
        /**
         * To get Api name
         * 
         * @return $string
         */
        public function getApiName();
        
        /**
         * To get WeatherCurrent Data Object
         * 
         * @return \App\Libs\Weather\DataType\WeatherCurrent
         */
        public function getWeatherData();
}